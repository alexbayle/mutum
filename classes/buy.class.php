<?php

class buy extends root{

    public $buy_id;
    public $buy_name;
    public $buy_price;
    public $buy_gift;
    public $buy_color;
    public $buy_color2;
    public $buy_active;
    public $buy_slug;

    public static $pref='buy_';

    public static function getOneBySlug($slug)
    {
        return \DB::SqlLine("SELECT * FROM buy WHERE buy_slug='{$slug}' AND buy_active=1;");
    }

}
