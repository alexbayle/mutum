<?php

class notification_cat extends root{

  //Attributs
  public $notc_id;
  public $notc_name;
  
  public static $pref='notc_';
  
  
  public static function getNotificationCat(){
      return DB::SqlToObj(array('notification_cat'),"Select * from notification_cat");
  }

};

?>