<?php

class share_community extends root
{

    //Attributs
    public $shac_prod_id;
    public $shac_comm_id;

    public static $pref = 'shac_';


    public static function findOneByCommunityAndProduct(community $community, product $product)
    {
        $query = sprintf(
            "SELECT * FROM share_community WHERE shac_comm_id='%s' AND shac_prod_id='%s'",
            $community->getAttr('id'),
            $product->getAttr('prod_id')
        );

        return DB::SqlOne($query);
    }

    public static function findOneByProduct($product)
    {
        return DB::SqlToObj(array('share_community'),"SELECT * FROM share_community WHERE shac_prod_id='".$product."'");
    }
}