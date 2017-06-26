  <?php

  $module =  $_REQUEST["module"];
  $btnrequest = Site::obtain_post("btnrequest");
  $art = article::Get(article::getActiveArticle($module));
  $article = article::getCurrentArticle($module);

  // dont know
  $NB_ART_PAGE = 10;

  $p = @$_GET['p'];
  if($p>=1){
      $p--;
  }

  $offset = $p*$NB_ART_PAGE;
  $p++;


  $start = microtime(true);
  $location_coords = Site::GetCoords($s_a_loc);
  $cat = category_article::returnCategoryForSearch($s_a_cat);
  $name = category_article::returnNameForSearch($s_a_name);

  $number_art_search = article::GetSearchResults($cat,$name,$location_coords,'','',true);

  $max_page = ceil($number_art_search / $NB_ART_PAGE);
  $tab_art_search = article::GetSearchResults($cat,$name,$location_coords,$offset,$NB_ART_PAGE);

  $end = microtime(true);


 $product = product::getProduct($module);
 $prodID = $product['prod_id'];
 $prodName = $product['prod_name'];
 $prodDesc = $product['prod_desc'];
 $prodFirstPic = $art->get_first_picture();

 $categoryArticle = $art->getCatName();

 $addr = $art->getAddress();


 $articleCaution = $art->getAttr('caution');
 $articlePrice = $art->getAttr('price');

 $art_dates = $art->getAttr('dates');
  if (count($art_dates)) {
      $art_dates = json_encode(array());
  }

  $prodOwnerID = $product['prod_user_id'];
  $prodOwner = product::getOwner($prodOwnerID);

  $prodOwnerName = $prodOwner['user_firstname']." ".$prodOwner['user_lastname'][0];

  $prodOwnerEmail = $prodOwner['user_email'];
  $prodOwnerPwd = $prodOwner['user_password'];

  $productAddedOn = $product['prod_date_creation'];
  $productAddress = address::getById($prodOwner['user_address']);
  if (count($productAddress)) {
  	$productAddress = $productAddress[0][0];

  	$prodOwnerCity = $productAddress->getAttr('city');
  }
  $lat = $article[0][3]->getAttr('latitude');
  $lng = $article[0][3]->getAttr('longitude');

  $me = $s_a_loc;
  $prodAndOwnerDistance = address::getDistance($me, array($lat, $lng));

  $prixTotalMutum = Site::obtain_post('prixTotalMutum');

  function initializeMango()
  {
      $mangoPayApi = new \MangoPay\MangoPayApi();
      $mangoPayApi->Config->ClientId = MANGOPAY_CLIENT_ID;
      $mangoPayApi->Config->ClientPassword = MANGOPAY_PASSPHRASE;
      $mangoPayApi->Config->TemporaryFolder = MANGOPAYTMP;
      $mangoPayApi->Config->BaseUrl = MANGOPAYAPI;


      return $mangoPayApi;
  }

  if(Session::Online()){
      $mangoPayApi = initializeMango();
      $userMangoId = \Session::Me()->user_mangopay_id;

      $Pagination = new \MangoPay\Pagination();
      $Pagination->Page = 1;
      $Pagination->ItemsPerPage = 100;
      $cards = $mangoPayApi->Users->GetCards($userMangoId,$Pagination);

  }
  if($btnrequest !="" )
  {
		if (Session::Online()==false)
		{
			Site::message_info("vous devez être connecté pour emprunter l'objet.","ERROR");
		}
		else
		{
			if (Session::Me()->isUserActive()){

				@$requ_date_from = Site::obtain_post("requ_date_from");
				@$requ_date_to = Site::obtain_post("requ_date_to");
				@$requ_message = Site::obtain_post("requ_message");
				@$card_id = Site::obtain_post('card_id');


				//initialisation de la variable error
				$error ="";
                $requ_nb_days = ((Site::md2php($requ_date_to) - Site::md2php($requ_date_from)) / 86400);
                $prix=(Session::me()->getAttr('credit'));
                $PrixTotal=($requ_nb_days*$art->getMutumByDay());

				//gestion des erreurs sur les champs
				if($requ_date_from == "")
				{
					$error="votre champ \"date de début\" n'est pas rempli";

				}
				else if($requ_date_to =="")
				{
					$error="votre champ \"date de fin\" n'est pas rempli";

				}
				else if ($requ_message =="")
				{
					$error="votre champ \"message\" n'est pas rempli";
				}

				else if(strlen($requ_message)<10)
				{
					$error="votre champ \"message\" n'a pas plus de 10 caracteres";

				}
			    //gestion des contrainte sur les champs
			    else if(request::isAvailableWithDate($module,$requ_date_from,$requ_date_to)==true)
				{
					$error="votre produit est déjà pris à cette date";

                }
			    else if ($requ_nb_days < 1)
				{
					$error = "la durée de l'emprunt est trop courte";

				}
			    else if (Site::md2php($requ_date_from) > Site::md2php($requ_date_to))
				{
					$error = "la date de début d'emprunt doit précéder la date de fin";
				}

			    else if (($error == "") && (Site::md2php($requ_date_from) < Site::md2php(Site::now())))
				{
					$error = "la date de début d'emprunt est dépassée";
				}
			    else if (($error == "") && (Site::md2php($requ_date_from)) > Site::md2php($requ_date_to))
				{
					$error = "la date de début d'emprunt doit précéder la date de fin";
				}
			    else if ($prix<$PrixTotal)
				{
					$error = "vous n'avez pas assez de mutums pour emprunter cet article sur cette durée";
				}
			    else if ($card_id=="" && $art->getAttr('caution')!="0")
				{
					$error = "aucune carte n'a été renseignée.";
				}
                if($art->getAttr('caution') > 0){
                    $mangopay=(mangopay::check_card_owner($card_id,Session::me()->getAttr('id')));

                    if($mangopay==false)
                    {
                        $error = "erreur: cette carte ne vous appartient pas !";
                    }
                    else{
                        $error = "";
                    }
                }


                if ($error == "") {
                    $caution = null;
                    if ($article[0][1]->getAttr('caution') > "0") {
                        $caution = new caution();
                        $caution->setAttr('amount', $art->getAttr('caution'));
                        $caution->setAttr('card_id', $card_id);
                        $caution->setAttr('caua_id', null);
                        $caution = $caution->Insert();
                    }


                    $discussion = new discussion;
                    $discussion->setAttr('all_grant_invit', '0');
                    $discussion->setAttr('date_creation', Site::now());
                    $discussion->setAttr('name', 'emprunt de ' . $art->getAttr('name'));
                    $discussionID = $discussion->Insert();

                    $unMessage = new message;
                    $unMessage->setAttr('user_id', Session::Me()->getAttr('id'));
                    $unMessage->setAttr('text', $requ_message);
                    $unMessage->setAttr('date_creation', Site::now());
                    $unMessage->setAttr('class', '');
                    $unMessage->setAttr('disc_id', $discussionID);
                    $unMessage->Insert();

                    $speaker = new speakers;
                    $speaker->setAttr('disc_id', $discussionID);
                    $speaker->setAttr('user_id', Session::Me()->getAttr('id'));
                    $speaker->setAttr('admin', 0);
                    $speaker->setAttr('seen', Site::now());
                    $speaker->setAttr('archived', 0);
                    $speaker->Insert();

                    $speakerd = new speakers;
                    $speakerd->setAttr('disc_id', $discussionID);
                    $speakerd->setAttr('user_id', $prodOwnerID);
                    $speakerd->setAttr('admin', 1);
                    $speakerd->setAttr('seen', Site::now());
                    $speakerd->setAttr('archived', 0);
                    $speakerd->Insert();

                    //calculer du prix total
                    //$PrixTotal = ($requ_nb_days * $art->getMutumByDay());
                    //gain de mutum de l'utilisateur
                    //Site::add_score_to_user(Session::Me()->getAttr('id'), $art->getMutumByDay(), 'Emprunt_creation');
                    \Site::apres_credit_to_user(Session::Me()->getAttr('id'),$prixTotalMutum,'Emprunt ' . $prodName);

                    //insertion dans la base de données
                    $register_request = new request();
                    $register_request->setAttr('lender_id', $art->getAttr('user_id'));
                    $register_request->setAttr('borrower_id', Session::Me()->getAttr('id'));
                    $register_request->setAttr('prod_id', $module);
                    $register_request->setAttr('date_creation', Site::now());
                    $register_request->setAttr('date_from', $requ_date_from);
                    $register_request->setAttr('date_to', $requ_date_to);
                    $register_request->setAttr('prol_id', null);
                    $register_request->setAttr('credit', $PrixTotal);
                    $register_request->setAttr('discussion', $discussionID);
                    $register_request->setAttr('code', null);
                    $register_request->setAttr('status', '6');
                    $register_request->setAttr('lender_nota_id', null);
                    $register_request->setAttr('borrower_nota_id', null);
                    $register_request->setAttr('prod_note', 0);
                    $register_request->setAttr('lender_archive', 0);
                    $register_request->setAttr('borrower_archive', 0);
                    $register_request->setAttr('lender_read', 0);
                    $register_request->setAttr('borrower_read', 0);
                    $register_request->setAttr('caut_id', $caution);
                    $register_request->setAttr('id', $register_request->Insert());

                    $owner = new user;
                    $owner->Create($prodOwner);

                    $productInComm = \share_community::findOneByProduct($article[0][0]->getAttr('prod_id'));
                    if($productInComm != array()) {
                        post::createFromLoanBorrowed($article[0][0], \Session::Me(), $register_request);
                    }
                    //post::createFromLoanLender($article[0][0], $owner, $register_request);


                    //$action = new \listener\subject\action($this);
                    //$action->attach(new \listener\observer\mail(\user::getById($art->getAttr('user_id'))[0][0]));
                    //$action->attach(new \listener\observer\success());
                    //$action->notify();

                    Site::message('Objet Emprunté !','INFO');
                    Site::redirect5sec(WEBDIR . 'loan');

                } else {
				    Site::message_info($error,"ERROR");
				    include (Site::include_view("view"));
			    }
			}
			else
			{
				echo " vous devez d'abord activer votre e-mail";
				include (Site::include_view("view"));
		        // renvoyer vers mail d'activation
			}
		}
  }
  else
  {
  	  $owner = user::getUser($article[0][2]->getAttr('user_id'));
	  include (Site::include_view("view"));

  }




?>
