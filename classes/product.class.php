<?php

class product extends root
{

    //Attributs
    public $prod_id;
    public $prod_user_id;
    public $prod_name;
    public $prod_desc;
    public $prod_limitation;
    public $prod_win;
    public $prod_notation;
    public $prod_nb_notation;
    public $prod_date_creation;
    public $prod_deleted;

    public static $pref = 'prod_';


    public function getProduct($id)
    {
        return DB::SqlLine("select * from product where prod_id = '" . $id . "'");
    }

    public static function getNumberProducts($userId)
    {
        return sizeof(user::getUserArticle($userId));
    }

    public function  getOwner($prodOwnerID)
    {
        return DB::SqlLine("select * from user where user_id = '" . $prodOwnerID . "'");
    }

    public function deleteProduct()
    {
        DB::SqlExec("update product set prod_deleted = '1' where prod_id = '" . $this->GetAttr('id') . "'");
    }

    public function clearAddress()
    {
        DB::SqlExec("delete from located_product where locp_prod_id='" . $this->GetAttr('id') . "'");
    }

    public function getNotation()
    {
        return DB::SqlToObj(
            array('notation'),
            "select * from notation where nota_prod_id='" . $this->getAttr('id') . "'"
        );
    }

    public function getNbNotation($prodId)
    {
        return DB::SqlOne("SELECT COUNT(*) FROM notation WHERE nota_prod_id=" . $prodId);
    }

    public static function searchProduct($product)
    {
        return DB::SqlToObj(
            array('product', 'article'),
            "select * from product, article where product.prod_id = article.arti_prod_id and prod_name LIKE '%" . $product . "%' AND prod_user_id = '" . Session::Me()->getAttr('id') . "' "
        );
    }

    public function addCommunity(community $community)
    {
        if (!\share_community::findOneByCommunityAndProduct($community, $this)) {
            $join = new share_community();
            $join->shac_comm_id = (int)$community->comm_id;
            $join->shac_prod_id = (int)$this->arti_prod_id;
            $join->Insert();
        }
    }

    /**
     *
     */
    public function getCommunities()
    {
        $query = sprintf(
            "SELECT *
              FROM community c
              LEFT JOIN share_community sc ON sc.shac_comm_id=c.comm_id
              LEFT JOIN product p ON p.prod_id=sc.shac_prod_id
              WHERE p.prod_id='%s'",
            $this->getAttr('id')
        );
        $communities = DB::SqlToObj(array('community'), $query);

        return $communities;
    }
}
