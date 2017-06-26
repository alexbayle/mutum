<?php

class wishlist extends post
{

    //Attributs
    public $wish_post_id;
    public $wish_virp_id;
    public $wish_address;
    public $wish_date;
    public $wish_desc;


    public static $pref = 'wish_';

    //Fonctions
    public static function supprimeUneDemande($id)
    {
        DB::SqlExec("delete from wishlist where wish_post_id=" . $id . "");

    }

    protected static function getNearWishQuery($offset, $lat, $lng)
    {
        return "
            SELECT *
            FROM wishlist w
            LEFT JOIN post p ON w.wish_post_id=p.post_id
            LEFT JOIN address a ON w.wish_address=a.addr_id
            WHERE w.wish_address = a.addr_id AND w.wish_post_id=p.post_id
            ORDER BY acos( sin( radians( addr_latitude ) ) * sin( radians( {$lat} ) ) + cos( radians( addr_latitude ) ) * cos( radians( {$lat} ) ) * cos( radians( addr_longitude ) - radians( {$lng} ) ) )
            "; //LIMIT {$offset}, 5;";//noLimit
    }

    public static function near5wish($offset, $latitude, $longitude)
    {
        $requete = self::getNearWishQuery($offset, $latitude, $longitude);
        return DB::SqlToObj(array("wishlist"), $requete);
    }

    public static function getNearWishWithFilters($params)
    {
        $query = self::getNearWishQuery($params['offset'], $params['lat'], $params['lng']);
        $leftJoin = " LEFT JOIN virtual_product vp ON w.wish_virp_id=vp.virp_id";
        $leftJoin .= " LEFT JOIN virtual_article va ON va.vira_virp_id=vp.virp_id";
        $leftJoin .= " LEFT JOIN category_article ca ON ca.cata_id=va.vira_cat";
        $addWhere = '';

        if ($params['productName']) {
            $addWhere .= " AND vp.virp_name LIKE '%{$params['productName']}%'";
        }

        if ($params['cat3']) {
            $addWhere .= " AND ca.cata_id={$params['cat3']}";
        } else if ($params['cat2']) {
            $addWhere .= " AND ca.cata_id={$params['cat2']} OR ca.cata_id IN (SELECT cata_id FROM category_article WHERE cata_parent_id={$params['cat2']})";
        } else if ($params['cat1']) {
            /**
             * todo
             *
             * Add products from all sub cat 3
             */
            $addWhere .= " AND ca.cata_id={$params['cat1']} OR ca.cata_id IN (SELECT cata_id FROM category_article WHERE cata_parent_id={$params['cat1']})";
        }

        if ($params['demandeContact']) {
            $addWhere .= " AND p.post_user_id=" . Session::Me()->user_id;
        }

        if ($params['demandeCible']) {

        }

        if ($params['demande']) {
            $addWhere .= " AND p.post_user_id=" . Session::Me()->user_id;
        }


        $query = preg_replace("/(ORDER BY .*)/", "{$addWhere} $1", $query, 1);
        $query = preg_replace("/(WHERE .*)/", "{$leftJoin} $1", $query, 1);

        return DB::SqlToObj(array('wishlist'), $query);
    }

    public static function getWishAddr($wishId)
    {
        return DB::SqlToObj(
            array("address"),
            "select * from address , wishlist where wish_address=addr_id and wish_post_id=" . $wishId . ""
        );
    }

    public static function getWishName($wishId)
    {

        return DB::SqlOne(
            "select virp_name from virtual_product, wishlist where wish_virp_id=virp_id and wish_post_id=" . $wishId . ""
        );
    }


    public static function prolongerDemander($id, $date)
    {
        DB::SqlExec(
            "update wishlist SET wish_date=" . $date . ""
            . "where wish_post_id=" . $id . ""
        );
    }

    public static function voirLesdemandes($id)
    {
        return DB::SqlToObj(
            array('wishlist', 'virtual_product', 'virtual_article', 'category_article', 'address', 'post'),
            "select *
from wishlist, virtual_product, virtual_article, category_article, address,post
where virp_id=wish_virp_id
and virp_id=vira_virp_id
and vira_cat=cata_id
and wish_address=addr_id
and post_id=wish_post_id
and post_user_id=" . $id
        );
    }

    public static function getByIdWithRelations($id)
    {
        return DB::SqlLine( "SELECT *
FROM wishlist w
LEFT JOIN virtual_product vp ON vp.virp_id=w.wish_virp_id
LEFT JOIN virtual_article va ON va.vira_virp_id=vp.virp_id
LEFT JOIN category_article ca ON ca.cata_id=va.vira_cat
LEFT JOIN address a ON a.addr_id=w.wish_address
LEFT JOIN post p ON p.post_id=wish_post_id
WHERE wish_post_id=" . $id);
    }
}

?>