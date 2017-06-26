<?php

class contact extends root{

	//Attributs
	public $cont_user_id_a;
	public $cont_user_id_b;
	public $cont_date_creation;
	public $cont_date_accepted;
	public $cont_status;

	public static $pref='cont_';
  
    public static function isContact($user_id){
        $r = DB::SqlOne("select count(*) from contact where ((cont_user_id_a='".Session::Me()->getAttr('id')."' and cont_user_id_b='$user_id') or (cont_user_id_b='".Session::Me()->getAttr('id')."' and cont_user_id_a='$user_id')) and cont_status='V'");
        if($r==0)
            return false;
        else
            return true;
    }

    public static function  askFriend($id){
        $unContact = new contact();
        $unContact->setAttr('user_id_a', Session::Me()->getAttr('id')) ;
        $unContact->setAttr('user_id_b',$id);
        $unContact->setAttr('date_creation',Site::now());
        $unContact->setAttr('date_accepted',null);
        $unContact->setAttr('status','A');
        $unContact->insert();
    }

    public static function  acceptFriend($id){
        DB::SqlExec("update contact SET cont_date_accepted='".Site::now()."', cont_status='V' where cont_user_id_b='". Session::Me()->getAttr('id')."' and cont_user_id_a='".$id."'");
    }

    public static function  denyAsk($id){
        DB::SqlExec("update contact SET  cont_date_accepted='".Site::now()."', cont_status='I' where cont_user_id_b='". Session::Me()->getAttr('id')."' and cont_user_id_a='".$id."'");
    }
    public static function cancelAsk($id) {
        DB::SqlExec("DELETE FROM contact WHERE (cont_user_id_a='" . Session::Me()->getAttr('id') . "' AND cont_user_id_b='" . $id . "' AND (cont_status='A' OR cont_status='I'))") ;
    }
    public static function deleteIgnored($id) {
        DB::SqlExec("DELETE FROM contact WHERE (cont_user_id_a='" . $id . "' AND cont_user_id_b='" . Session::Me()->getAttr('id') . "') AND (cont_status='A' OR cont_status='I')") ;
    }

    public static function  deleteFriend($id){
    DB::SqlExec("delete from contact where (cont_user_id_a='".$id."' and  cont_user_id_b='". Session::Me()->getAttr('id')."') or (cont_user_id_b='".$id."' and  cont_user_id_a='". Session::Me()->getAttr('id')."')");

    }
    public static function seeWaitingAsks(){
    return DB::SqlToObj(array('user'),"select * from  user,contact  where user.user_id=contact.cont_user_id_a and cont_status='A' and  cont_user_id_b=". Session::Me()->getAttr('id'));
    }
    public static function seeMyAsks(){
    return DB::SqlToObj(array('user'),"select *  from user,contact  where user.user_id=contact.cont_user_id_b and  (cont_status='A' or cont_status='I') and  cont_user_id_a='". Session::Me()->getAttr('id')."'");
    }
    public static function seeAllContact(){
    return DB::SqlToObj(array('user'),"select * from contact,user  where (user.user_id=contact.cont_user_id_b or user.user_id=contact.cont_user_id_a) and cont_status='V' and ( cont_user_id_a=".Session::Me()->getAttr('id')." or cont_user_id_b=".Session::Me()->getAttr('id').") ORDER BY user.user_firstname");
    }
    public static function seeRefused(){
        return DB::SqlToObj(array('user'),"select *  from contact,user  where user_id=cont_user_id_a and cont_status='I' and cont_user_id_b='". Session::Me()->getAttr('id')."'");
    }
    public static function checkExistAsk($id){
        $nb=DB::SqlOne("select count(*) from contact where cont_user_id_a='".$id."' and  cont_user_id_b='". Session::Me()->getAttr('id')."' and (cont_status='A' or cont_status='I')");
        if($nb>0){
            return true;
        }
        else{
            return false;
        }
    }
    public static function checkExistContactForDelete($id){
        $nb=DB::SqlOne("select count(*) from contact where cont_status='V' and ((cont_user_id_a='".$id."' and cont_user_id_b='".Session::Me()->getAttr('id')."') or (cont_user_id_b='".$id."' and cont_user_id_a='".Session::Me()->getAttr('id')."'))");
        if($nb>0){
            return true;
        }
        else{
            return false;
        }
    }
    public static function checkExistMyAsk($id){
        $nb=DB::SqlOne("select count(*) from contact where cont_user_id_b='".$id."' and cont_user_id_a='".Session::Me()->getAttr('id')."' and cont_status='A'");
        if($nb>0){
            return true;
        }
        else{
            return false;
        }
    }
    public static function countContact($id){
        $nb=DB::SqlOne("select count(*) from contact where (cont_user_id_b='".Session::Me()->getAttr('id')."' and cont_user_id_a='".$id.") or (cont_user_id_a='".Session::Me()->getAttr('id')."' and cont_user_id_b='".$id." )");
        if($nb>0){
            return true;
        }
        else{
            return false;
        }

    }
    public static function countMyContact(){
        return DB::SqlOne("select count(*) from contact where cont_user_id_b = ".Session::Me()->getAttr('id')." or cont_user_id_a = ".Session::Me()->getAttr('id')." and cont_status = 'V'");
    }



  
  //Fonctions

};

?>