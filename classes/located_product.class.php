<?php

class located_product extends root{

  //Attributs
  public $locp_prod_id;
  public $locp_addr_id;
  
  public static $pref='locp_';
  
  
  //Fonctions
public static function checkLp($prod_id, $addr_id)
{
	return DB::SqlLine("select * from located_product where locp_prod_id='$prod_id' and locp_addr_id='$addr_id'");
}
};

?>