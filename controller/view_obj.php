<?php
 @$module =  $_GET["module"];
  @$btnrequest = Site::obtain_post("btnrequest");
  @$btnEmprunt = Site::obtain_post("btnEmprunt");
  @$btnEmprunt = Site::obtain_post("btnEmprunt");
  $art= article::Get( article::getActiveArticle($module));
  $owner=user::getUser($art->getAttr('user_id'))[0][0];
$btnCase=0;
	if($module!='')
  {
    $art = article::Get(article::getActiveArticle($module));
	if ($art->GetAttr('id')=="")
	
	{
	  Site::redirect(WEBDIR.'home');      
      exit();
	}
	if($art->GetAttr('name')!='' && ($art->GetAttr('user_id')==Session::Me()->GetAttr('id') || Session::isAdmin()) && request::isAvailable($art->GetAttr('user_id')))
      {
		$btnCase=1;
	  }
	  

  }
  
include(Site::include_view("view_obj"));
?>