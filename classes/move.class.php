<?php

class move extends root
{

    //Attributs
    public $move_id;
    public $move_user_id;
    public $move_article_id;
    public $move_date_creation;
    public $move_type;
    public $move_amount;

    public static $pref = 'move_';


    //Fonctions

    public static function getByUserId($userId)
    {
        return DB::SqlToObj(array("move"), "SELECT * FROM move WHERE move_user_id='".Session::Me()->getAttr('id')."'");
    }

    public static function getWithCatByUserId($userId)
    {
        return DB::SqlToObj(array("move", "article", "category_article"), "
SELECT *
FROM move m
LEFT JOIN article a ON m.move_article_id=a.arti_prod_id
LEFT JOIN product p ON p.prod_id=a.arti_prod_id
LEFT JOIN category_article ca ON ca.cata_id=a.arti_cat
WHERE move_user_id='".Session::Me()->getAttr('id')."'
ORDER BY move_id DESC");
    }

    public static function getWithCatByUserId3($userId)
    {
        return DB::SqlToObj(array("move", "article", "category_article"), "
SELECT *
FROM move m
LEFT JOIN article a ON m.move_article_id=a.arti_prod_id
LEFT JOIN product p ON p.prod_id=a.arti_prod_id
LEFT JOIN category_article ca ON ca.cata_id=a.arti_cat
WHERE move_user_id='".Session::Me()->getAttr('id')."'
ORDER BY move_id DESC
LIMIT 5");
    }
}