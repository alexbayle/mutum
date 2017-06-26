<?php

class sponsor extends root
{
    public $spon_user_id;
    public $spon_email;
    public $spon_date_creation;
    public $spon_unsubscribe_code;

    public static $pref = 'spon_';


    public static function exists($mail)
    {
        return DB::SqlOne("select spon_email from sponsor where spon_email='{$mail}'") ? true : false;
    }
}
