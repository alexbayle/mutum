<?php

class notification_user extends root{

  //Attributs
  public $notu_user_id;
  public $notu_notm_id;
  
  public static $pref='notu_';
  
  public static function getNotifUser($user_id,$notif_id){
    return DB::SqlOne("SELECT count(*) FROM notification_user WHERE notu_user_id = ".$user_id." AND notu_notm_id = ".$notif_id." ");
  }

};

?>