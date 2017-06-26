<?php

class discussion extends root {

    //Attributs
    public $disc_id;
    public $disc_all_grant_invit;
    public $disc_date_creation;
    public $disc_name;
    public static $pref = 'disc_';

    public function getDiscussion() {
        return $this->disc_id;
    }

    //Fonctions

    public static function createDiscuss($name, $grant) {
       DB::SqlExec("INSERT INTO discussion VALUES('', '" . $grant . "', '" . Site::now() . "', '" . $name . "')") ;
    }

    public static function activeDiscuss($id) {
        return DB::SqlToArray("select * from speakers where spea_user_id = '$id' and spea_achived = '0'");
    }

    public static function archivedDiscuss($id) {
        return DB::SqlToArray("select * from speakers where spea_user_id = '$id' and spea_achived = '1'");
    }

    public function chkNewMsg($id) {
        $date_seen = DB::SqlOne("select spea_seen from speakers where spea_user_id='$id' and spea_disc_id= '$this->id'");
        $last_msg = DB::SqlOne("SELECT `mess_date_creation` FROM `message` WHERE `mess_id`>=all (select `mess_id` from message M, discussion D, speakers S where M.`mess_disc_id`=D.disc_id and D.disc_id=S.spea_disc_id and spea_user_id<>'$id' and D.disc_id = '$this->id')");



        if (Site::md2php($date_seen) < Site::md2php($last_msg)) {
            return true;
        } else
            return false;
    }

    public static function voirMesMessages() {
        return DB::SqlToObj(array("discussion", "speakers"), "SELECT * FROM discussion, speakers WHERE spea_user_id='" . Session::Me()->getAttr('id') . "' AND disc_id = spea_disc_id ORDER BY disc_date_creation DESC");
    }

    public static function myDisccuss(){
        return DB::SqlToObj(array("discussion","speakers","message","user"), "SELECT *
FROM discussion,speakers,message,user
WHERE disc_id = spea_disc_id
AND disc_id = mess_disc_id
AND mess_user_id = user_id
AND spea_user_id='" . Session::Me()->getAttr('id') . "'
GROUP BY disc_id
ORDER BY mess_id DESC");
    }
    public static function searchDiscu($username){
        return DB::SqlToObj(array("discussion","speakers","message","user"), "SELECT *
FROM discussion,speakers,message,user
WHERE disc_id = spea_disc_id
AND disc_id = mess_disc_id
AND mess_user_id = user_id
AND spea_user_id='" . Session::Me()->getAttr('id') . "'
AND user_firstname Like '%".$username."%'
GROUP BY disc_id
ORDER BY mess_id DESC");
    }

    public static function listDiscuss(){
        return DB::SqlToObj(array("discussion","speakers","message","user"),"SELECT *
FROM `discussion`,`speakers`,`message`,`user`
WHERE disc_id = spea_disc_id
AND disc_id = mess_disc_id
AND spea_user_id = user_id
AND spea_user_id != ".Session::Me()->getAttr('id')."
AND disc_id = ".Session::Me()->getAttr('id')."
group by spea_disc_id
ORDER BY mess_id DESC");
    }

    public static function discuDest($disc_id){
        return DB::SqlToObj(array("discussion","speakers","user"), "Select *
from speakers, discussion, user
where disc_id = spea_disc_id
and spea_user_id = user_id
and disc_id = ".$disc_id."
and user_id != ".Session::Me()->getAttr('id')."
");
    }

    public static function voirMessageArchivé($id) {
        return DB::SqlToObj(array("discussion", "speakers"), "select * from discussion,speakers where disc_id=spea_disc_id and spea_archived=1 and spea_user_id=$id order by disc_date_creation DESC");
    }

    public static function messageArchive($id) {
        return DB::SqlExec("update speakers set  spea_achived=1 where spea_disc_id" . $id . "");
    }

    public static function VoirMesDiscussion($id) {
        $lesid = DB::SqlToArray("select spea_disc_id from speakers where spea_user_id=" . $id . " and spea_user_id<>" . Session::me()->getAttr('id') . "");
        $tab = array();


        foreach ($lesid as $unid) {
            $m = DB::SqlToObj(array("discussion", "speakers"), "select * from discussion,speakers where spea_disc_id=" . $unid . " and disc_id=spea_disc_id ");

            array_push($tab, $m);
        }
        return $tab;
    }

    public static function getDiscuTitle($id){
        return DB::SqlToArray("select disc_name from discussion where disc_id = '".$id."' ");
    }

    public static function msgFromDiscuss($discId) {
        return DB::SqlToObj(array("message","user"), "select * from user,message where user_id = mess_user_id and mess_disc_id=$discId order by mess_date_creation ASC");
    }

    public static function InsertionSpeakers($id) {
        return DB::SqlExec("update discussion set disc_all_grant_invit=1 where spea_disc_id" . $id . "");
    }
    
    public static function renameDiscuss($discId, $discName) {
        DB::SqlExec("UPDATE discussion SET disc_name='" . $discName . "' WHERE disc_id=" . $discId) ;
    }
    
    public static function getAllgrantinvit($discId) {
        $req = DB::SqlOne("SELECT COUNT(*) FROM discussion WHERE disc_id=" . $discId . " AND disc_all_grant_invit=1") ;
        if($req > 0) {
            return true ;
        } else {
            return false ;
        }
    }


}
