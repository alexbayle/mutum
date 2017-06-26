<?php

if(isset($_POST['action']) && !empty($_POST['action']))
{
	//sending mail
	require_once('../../lib/mailjet/mailjet.class.php');
	//var_dump($_POST['productOwnerEmail']); die();
	$mj = new Mailjet();
	$params = array(
			"method" => "POST",
			"from" => $_POST['from'],
			"to" => $_POST['productOwnerEmail'],
			"subject" => "Emprunte",
			"html" => $_POST['debutDate']."".$_POST['finDate']."".$_POST['content']
	);
	//"inlineattachment" => array("@http://".$SITEURL."/mails/ressources/mailjet_img1.png","@http://".$SITEURL."/mails/ressources/mailjet_img2.png"),
	$result = $mj->sendEmail($params);

    if ($mj->_response_code == 200)
       echo "Success - Email Sent";
    else
       echo "Error - ".$mj->_response_code;

    //return $result;
	//var_dump($mj); die(); */
	
	//sending a message to the owner on mutum
	//first start a discussion
	$discuss = new discussion;
	
	$discuss->setAttr("all_grant_invit", 0);
	$discuss->setAttr("date_creation", Site::now());
	$discuss->setAttr("name", $_POST['forProduct']);
	
	$discId = $discuss->Insert();
	
	//send message
	$unMessage = new message;
	$unMessage->setAttr("user_id", $_POST['fromId']);
	$unMessage->setAttr("text", $_POST['content']);
	$unMessage->setAttr("date_creation", Site::now());
	$unMessage->setAttr("class", "");
	$unMessage->setAttr("disc_id", $discId);
	$unMessage->insert();
	//var_dump($unMessage); die;
	
	//add speakers
	$speak_id = array($_POST['fromId'], $_POST['toId']);
	//$admin_id=Site::obtain_post('admin_id');
	foreach ($speak_id as $id)
	{
		$speaker= new speakers;
		$speaker->setAttr("disc_id",$discId);
		$speaker->setAttr("user_id",$id);
		$speaker->setAttr("admin",0);
		$speaker->setAttr("seen",0);
		$speaker->setAttr("archived",0);
		$speaker->insert();
	}
	/* $speaker= new speakers;
	$speaker->setAttr("disc_id",$discId);
	$speaker->setAttr("user_id",$admin_id);
	$speaker->setAttr("admin",1);
	$speaker->setAttr("seen",0);
	$speaker->setAttr("archived",0); */
	
	
	return "Success!!";
	
}
?>