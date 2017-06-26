<?php

class special_title extends root{

  //Attributs
  public $spec_id;
  public $spec_name;
  
  public static $pref='spec_';
  
  //Fonctions
  public static function getMyTitle($id)
  {
	return DB::SqlToArray("select spec_name from special_title S, owned_title O where O.ownt_spec_id=S.spec_id and ownt_user_id='$id'");
  }
};

?>