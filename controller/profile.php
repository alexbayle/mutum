<?php
if (Session::online())
{
	// récupération des informations de l'utilisateur afin de les afficher dans la vue
	$user=Session::Me();
	if ($user->GetAttr('active') != "1")
	{
		echo " vous devez d'abord activer votre e-mail";
		// renvoyer vers mail d'activation
	}
	
	
	$btneddit = Site::obtain_post('btneddit');
	$btnconfirm = Site::obtain_post('btnconfirm');
	$btncancel = Site::obtain_post('btncancel');
	// en cas d'edition des informations
	
	//recuperation des succès
	$myAchievements = achievements::getAllByUser($user->user_id);
	$nbAchievements = achievements::countAchievements();

	if (0 != count($nbAchievements)) {
		$nbAchievements = $nbAchievements[0]['count'];
	}

    //wallet
    $history = \category_article::getCountByUser(Session::Me()->user_id);


    //pret - emprunt
    $borrowInProgress = request::borrowInProgress();
    $lendInProgress = request::lendInProgress();

    if ($btneddit!='')
	{

		
		include(Site::include_view('eddit'));
	}
	else
		if($btnconfirm != '')
		{
			// récupération des données saisient par l'utilisateur
			
			$firstname=Site::obtain_post("firstname");
			$lastname=Site::obtain_post("lastname");
 			$lastpsswd=Site::obtain_post("lastpsswd");
			$password=Site::obtain_post("password");
			$passwordC=Site::obtain_post("passwordC");
			$full_address=Site::obtain_post("address");
			$address=Site::GetFullAddress($full_address)[0];
			$zip=Site::GetFullAddress($full_address)[1];
			$city=Site::GetFullAddress($full_address)[2];
			$birthdate=Site::obtain_post("birthdate");
            $email=Site::obtain_post("email");
			$sex=Site::obtain_post('sex');
			$phone=Site::obtain_post("phone");
			$phone_hide=Site::obtain_post("phone_hide");
			$title=Site::obtain_post('title');
			$btn_pwd=Site::obtain_post("btn_pwd");
            $picture = $_FILES["picture"]["name"];
			// Gestion des erreurs
			$error = array();
			if($firstname=="" || strlen($firstname)<2 )
			{
				$error[]="veuillez remplir votre prénom";
			}
			if($lastname=="" || strlen($lastname)<2 )
			{
				$error[]="veuillez remplir votre nom";
			}
			if ($btn_pwd==1)
			{
				if($password=="" || strlen($password)<6)
				{
					$error[]="votre mot de passe doit contenir au moins 6 caractères";
				}
				if($password!=$passwordC)
				{
					$error[]="erreur lors de la confirmation votre mot de passe";
				}
				if(Site::crypt_pwd($lastpsswd)!= $user->GetAttr('password'))
				{
					$error[]="mot de passe incorrect";
				}
			}
			$coords = Site::GetCoords($full_address);
			if($coords[0]==0 && $coords[1]==0)
			{
				$error[] = "localisation introuvable, veuillez la changer.";
			}
			if($full_address=="")
			{
				$error[]="veuillez remplir votre adresse";
			}
			if($birthdate== "")
			{
				$error[]="veuillez remplir votre date de naissance";
			}
            if ($picture!="")
            {
                $path_info = pathinfo($picture);
                $user_picture_ext = $path_info['extension'];
                //$allowed_exts = array("jpeg", "jpg", "png", "gif");
                $allowed_exts = array("jpg", "png", "jpeg","JPG","JPEG","PNG");
                if (!(in_array($user_picture_ext, $allowed_exts)))
                {
                    $error[] = "format non autorisé";
                }
                else
                {
                    // Suppression des anciennes photos
                    if ($user_picture_ext != "jpg") { @unlink("img/user/".Site::swat_hash(Session::Me()->getAttr('id')).".jpg"); }
                    if ($user_picture_ext != "png") { @unlink("img/user/".Site::swat_hash(Session::Me()->getAttr('id')).".png"); }
                    if ($user_picture_ext != "jpeg") { @unlink("img/user/".Site::swat_hash(Session::Me()->getAttr('id')).".jpeg"); }
                    if (move_uploaded_file($_FILES["picture"]["tmp_name"],
                        "img/user/".Site::swat_hash(Session::Me()->getAttr('id')).".$user_picture_ext"))
                    {
                        Site::ResizeImageCenterCrop("img/user/".Site::swat_hash(Session::Me()->getAttr('id')).".$user_picture_ext", 140, 140);
                    }
                }
            }
			
			
			if (sizeof($error)>0)
			{
			  Site::message_info($error, 'ERROR');
			  include(Site::include_view('eddit'));
			}
			else
			{
			$new_user = new user();
			$new_user->setAttr('id', $user->GetAttr('id'));
			$new_user->setAttr('email', $user->GetAttr('email'));
			$new_user->setAttr('firstname', $firstname);
			$new_user->setAttr('lastname', $lastname);
			
			if($password != "")
				$new_user->setAttr('password',Site::crypt_pwd($password));
			else
				$new_user->setAttr('password', $user->GetAttr('password'));

            $new_adresse = new address();
			
			$new_user->setAttr('admin', $user->GetAttr('admin'));
			$new_user->setAttr('address', $new_adresse->checkAddr($full_address));
			//$new_user->setAttr('zip', $zip);
			//$new_user->setAttr('city', $city);
			$new_user->setAttr('birthdate', $birthdate);
			$new_user->setAttr('sex', $sex);
			$new_user->setAttr('phone', $phone);
			$new_user->setAttr('phone_hide', $phone_hide);
			$new_user->setAttr('sponsor_code', $user->GetAttr('sponsor_code'));
			$new_user->setAttr('title', $title);
			$new_user->setAttr('godfather', $user->GetAttr('godfather'));
			$new_user->setAttr('mangopay_id', $user->GetAttr('mangopay_id'));
			$new_user->setAttr('facebook_id', $user->GetAttr('facebook_id'));
			$new_user->setAttr('credit',  $user->GetAttr('credit'));
			$new_user->setAttr('rank',$user->GetAttr('rank'));
			$new_user->setAttr('nb_notation',$user->GetAttr('nb_notation'));
			$new_user->setAttr('notation',$user->GetAttr('notation'));
			$new_user->setAttr('date_creation','test');
            $new_user->setAttr('email',$email);

			$new_user->setAttr('date_last_connection',$user->GetAttr('date_last_connection'));
			$new_user->setAttr('active',$user->GetAttr('active'));
			$new_user->setAttr('online',$user->GetAttr('online'));
			$new_user->setAttr('score',$user->GetAttr('score'));
			$new_user->Update();

            Site::message("modification enregistrée","INFO");
            Site::redirect5Sec(WEBDIR."profile");
			
			}
		}
	else
    {
	    include(Site::include_view('profile'));
	}
}
?>