<?php

class notification_mail extends root{

	//Attributs
	public $notm_id;
	public $notm_name;
	public $notm_short;
	public $notm_notc_id;

	public static $pref='notm_';



	//Fonctions
  
	public static function shouldSendMail($mail,$user_id){
		$rec = DB::SqlOne("select count(*) from notification_user,notification_mail where notm_id=notu_notm_id and notu_user_id='$user_id' and notm_short='$mail'");
		if($rec==0)
			return true;
		else
			return false;
	}

    public static function getNotificationMail($noti_id){
       return DB::SqlToObj(array('notification_mail'),"Select * from notification_mail where notm_notc_id = ".$noti_id."");
    }

    public static function updateNotificationMail($noti_id,$user_id){
       DB::SqlExec("INSERT INTO notification_user (notu_user_id,notu_notm_id) VALUES (".$user_id.",".$noti_id.")");
    }

};

?>