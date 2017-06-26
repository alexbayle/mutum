<?php
if (Session::online())
{
	@$module =  $_GET["module"];
	$add=Site::obtain_post("btnAdd");
	$del=Site::obtain_post("btnSupp");
	$msg=Site::obtain_post("btnSend");
	$name=Site::obtain_post("discName");
	$text=Site::obtain_post("text");
	$cancel=Site::obtain_post("btnCancelAsk");
	$sendMsg=Site::obtain_post("sendmsg");
	$user=user::getUser($module)[0][0];
	$articles = user::getUserArticle($user->getAttr('id'));
	$nbArticle = count(user::getUserArticle($user->getAttr('id')));
	$pages=array();
	$pagination=true;
	$lastArticles =user::getUserArticle($user->getAttr('id'),"order by prod_date_creation",5);

	// pagination créee par josué //////////////////////////////////////////////////////////////////////////////////////////////////
		/*fonction createPage()
		* parametre: aucun
		*role:cree une page dans l'array $pages
		*/
	 function createPage($start,$stop,$articles){
		$page=array();
		for($i=$start;$i<$stop;$i++){
			array_push($page,$articles[$i]);
		}
		return $page;
	}



		if($nbArticle ==4 || $nbArticle<3){
			//include "pages/user/templates/list.php";
		}


		if($nbArticle==3 || $nbArticle==5){

		}
		
		
		//if($nbArticle>5){

			$pagination=true;
			
			$objParPage=5;//nombre d'articles par page
			$nombreDePages=ceil($nbArticle/$objParPage);

			$pages = array();//array qui contiendra les articles dans des pages($pages =array(page n=> n articles))
			$bornes = array();// borne d'intervalle de decoupage des articles
			
			for ($y=0; $y<$nbArticle ; $y++){

				if($y%$objParPage==0){
					array_push($bornes,$y);
				}		
			}
			array_push($bornes,$nbArticle);
			sort($bornes);
			foreach($bornes as $k=>$val){		
				if($k+1<count($bornes)){
					$page = createPage($val,$bornes[$k+1],$articles);
					array_push($pages,$page);					
				}
			}
		//}
		


    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//var_dump($module);
	if ($add!="")
	{
		contact::askFriend($module);
	}

	if($sendMsg!=""){
		Site::redirect(WEBDIR .'inbox');
	}

	
	if($del != "" || $cancel != "")
	{
		contact::deleteFriend($module);
	}
	
	if($msg != "")
	{
		$discuss=new discussion;
		$discuss->setAttr("all_grant_invit",0);
		$discuss->setAttr("date_creation",Site::now());
		$discuss->setAttr("name",$name);
		$discId=$discuss->insert();
		
		$speaker= new speakers;
		$speaker->setAttr("disc_id",$discId);
		$speaker->setAttr("user_id",Session::Me()->getAttr('id'));
		$speaker->setAttr("admin",1);
		$speaker->setAttr("seen",Site::now());
		$speaker->setAttr("archived",0);
		$speaker->insert();
		
		$speaker= new speakers;
		$speaker->setAttr("disc_id",$discId);
		$speaker->setAttr("user_id",$module);
		$speaker->setAttr("admin",0);
		$speaker->setAttr("seen","");
		$speaker->setAttr("archived",0);
		$speaker->insert();
		
		$unMessage = new message;
		$unMessage->setAttr("user_id",Session::Me()->getAttr('id'));
		$unMessage->setAttr("text",$text);
		$unMessage->setAttr("date_creation",Site::now());
		$unMessage->setAttr("class","");
		$unMessage->setAttr("disc_id",$discId);
		$unMessage->insert();
	}
include(Site::include_view('user'));
}
?>