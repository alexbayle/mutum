<?php

class caroussel extends root{

  //Attributs
  public $caro_id;
  public $caro_text;
  public $caro_user_id;
  public $caro_weight;
  public $caro_date_from;
  public $caro_date_to;
  public $caro_limitation

  
  public static $pref='caro_';
  
  //Fonctions

 public static function checkCaroWithNoLimit(){
 
 return DB::SqlToObj(array('caroussel'),"select * from caroussel where caro_limitation=0");
 }
};

?>