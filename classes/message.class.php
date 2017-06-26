<?php

class message extends root
{
    //Attributs
    public $mess_id;
    public $mess_user_id;
    public $mess_disc_id;
    public $mess_text;
    public $mess_date_creation;
    public $mess_class;

    public static $pref = 'mess_';


    //Fonctions

    public static function createMsg($dId, $text, $class = "")
    {
        $msg = new message();
        $msg->setAttr('text', $text);
        $msg->setAttr('date_creation', Site::now());
        $msg->setAttr('class', $class);
        $msg->setAttr('disc_id', $dId);
        $msg->insert();

    }

    public static function deleteMsg($id)
    {
        DB::SqlExec("delete from message where mess_id='" . $id . "'");

    }

    public static function getMessageById($id)
    {
        return DB::SqlToObj(array('message'),"SELECT * FROM message WHERE mess_disc_id = ".$id." ORDER BY mess_id DESC LIMIT 1 ");
    }
}
