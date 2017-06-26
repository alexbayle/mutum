<?php

class speakers extends root{

  //Attributs
  public $spea_disc_id;
  public $spea_user_id;
  public $spea_admin;
  public $spea_seen;
  public $spea_archived;
  
  public static $pref='spea_';
  
  //Fonctions
    public static function etreAdmin($userId, $discId) {
        $req = DB::SqlOne("SELECT COUNT(*) FROM speakers WHERE spea_user_id=" . $userId . " AND spea_disc_id=" . $discId . " AND spea_admin=1") ;
        if($req > 0) {
            return true ;
        } else {
            return false ;
        }
    }
    
    public static function AddToUserDiscussion($discId, $userId) {
        DB::SqlExec("INSERT INTO speakers VALUES(" . $discId . "," . $userId . ",0,'0',0)") ;
    }
    
    public static function becomeAdmin($discId, $userId) {
        DB::SqlExec("UPDATE speakers SET spea_admin=1 WHERE spea_disc_id=" . $discId . " AND spea_user_id=" . $userId) ;
    }
    public static function removeAdmin($discId) {
        DB::SqlExec("UPDATE speakers SET spea_admin=0 WHERE spea_admin=1 AND spea_disc_id=" . $discId) ;
    }
    
    public static function getSpeakers($discId) {
        return DB::SqlToObj(array('user'), "SELECT user_id, user_firstname, user_lastname FROM user, speakers WHERE spea_user_id=user_id AND user_id != '".Session::Me()->getAttr('id')."' AND spea_disc_id=" . $discId) ;
    }
    
    public static function messageSeen($discId, $userId) {
        DB::SqlExec("UPDATE speakers SET spea_seen=NOW() WHERE spea_disc_id=" . $discId . " AND spea_user_id=" . $userId) ;
    }
}
?>