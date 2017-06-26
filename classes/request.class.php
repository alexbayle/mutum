<?php

class request extends root
{

    //Attributs
    public $requ_id;
    public $requ_lender_id;
    public $requ_borrower_id;
    public $requ_prod_id;
    public $requ_discussion;
    public $requ_status;
    public $requ_lender_nota_id;
    public $requ_borrower_nota_id;
    public $requ_date_creation;
    public $requ_date_from;
    public $requ_date_to;
    public $requ_prol_id;
    public $requ_credit;
    public $requ_code;
    public $requ_prod_note;
    public $requ_lender_archive;
    public $requ_borrower_archive;
    public $requ_lender_read;
    public $requ_borrower_read;
    public $requ_caut_id;
    public $requ_delete;

    public static $pref = 'requ_';

    //Fonctions

    public static function isAvailable($id)
    {
        $sql = "select count(*) from request where requ_prod_id='$id' and ((requ_status=1) or(requ_status=6) or(requ_status=5 and requ_date_to>=CURDATE() and requ_caut_id<=0))";
        if (DB::sqlone($sql) == 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function isAvailableWithDate($art_id, $date1, $date2)
    {
        $date1 = Site::fd2md($date1);
        $date2 = Site::fd2md($date2);
        $sql = "select count(*) from request where requ_prod_id = '$art_id' and (requ_status='5') and (requ_date_from between '$date1' and '$date2'or requ_date_to between '$date1' and '$date2'or requ_date_from <= '$date1' and requ_date_to >= '$date2')";

        if (DB::sqlone($sql) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getMyLend()
    {
        return DB::SqlToObj(
            array('request', 'request_status', 'product', 'article', 'category_article', 'user', 'address'),
            "select * from request,request_status,product,article,category_article,user,address
      where request.requ_status = request_status.reqs_id
      and request.requ_prod_id = product.prod_id
      and product.prod_id =article.arti_prod_id
      and article.arti_cat = category_article.cata_id
      and product.prod_user_id = user.user_id
      and user.user_address = address.addr_id
      and requ_lender_id = " . Session::Me()->getAttr('id') . "
      and requ_lender_archive = 0
      and requ_delete is null
      order by requ_id desc
      "
        );
    }

    public static function getMyBorrow()
    {
        return DB::SqlToObj(
            array('request', 'request_status', 'product', 'article', 'category_article', 'user', 'address'),
            "select * from request,request_status,product,article,category_article,user,address
      where request.requ_status = request_status.reqs_id
      and request.requ_prod_id = product.prod_id
      and product.prod_id =article.arti_prod_id
      and article.arti_cat = category_article.cata_id
      and product.prod_user_id = user.user_id
      and user.user_address = address.addr_id
      and requ_borrower_id = " . Session::Me()->getAttr('id') . "
      and requ_borrower_archive = 0
      and requ_delete is null
      order by requ_id desc
      "
        );
    }

    public static function getMyArchive()
    {
        return DB::SqlToObj(
            array('request', 'request_status', 'product', 'article', 'category_article', 'user', 'address'),
            "select * from request,request_status,product,article,category_article,user,address
      where request.requ_status = request_status.reqs_id
      and request.requ_prod_id = product.prod_id
      and product.prod_id =article.arti_prod_id
      and article.arti_cat = category_article.cata_id
      and product.prod_user_id = user.user_id
      and user.user_address = address.addr_id
      and requ_borrower_id = " . Session::Me()->getAttr('id') . "
      and (requ_borrower_archive = 1 OR requ_lender_archive = 1)
      order by requ_id desc
      "
        );
    }

    public static function getMyCurrentRequest($id)
    {
        return DB::SqlLine("select * from request where requ_id =" . $id . "");
    }

    public function getStatus()
    {
       return \request_status::get($this);
    }

    public static function borrowInProgress()
    {
        return DB::SqlToObj(array('request', 'request_status', 'product', 'article', 'category_article', 'user', 'address'),"
        select * from request,request_status,product,article,category_article,user,address
      where request.requ_status = request_status.reqs_id
      and request.requ_prod_id = product.prod_id
      and product.prod_id =article.arti_prod_id
      and article.arti_cat = category_article.cata_id
      and product.prod_user_id = user.user_id
      and user.user_address = address.addr_id
      and requ_borrower_id = " . Session::Me()->getAttr('id') . "
      and reqs_id = 2
      order by requ_id desc
      limit 1
        ");
    }

    public static function lendInProgress()
    {
        return DB::SqlToObj(array('request', 'request_status', 'product', 'article', 'category_article', 'user', 'address'),"
        select * from request,request_status,product,article,category_article,user,address
      where request.requ_status = request_status.reqs_id
      and request.requ_prod_id = product.prod_id
      and product.prod_id =article.arti_prod_id
      and article.arti_cat = category_article.cata_id
      and product.prod_user_id = user.user_id
      and user.user_address = address.addr_id
      and requ_lender_id = " . Session::Me()->getAttr('id') . "
      and reqs_id = 2
      order by requ_id desc
      limit 1
        ");
    }


    public static function getMessageById($id)
    {
        return DB::SqlToObj(array('message'),"
SELECT *
FROM message
WHERE mess_disc_id = ".$id."
ORDER BY mess_id DESC
LIMIT 1
");
    }

    public function calculDateDiff(){
        $date1 = new DateTime('NOW');

        $date_to = $this->requ_date_to;
        $date2 = new DateTime($date_to);
        $date2->setTime(23,59,59);

        $interval = $date2->diff($date1);


        if($interval->format('%d') > 30  ){
            return $interval->format('il reste %m mois');
        }if($interval->format('%h') > 24  || $interval->format('%d') >= 1){
            return $interval->format('il reste %d jours');
        }if($interval->format('%i') > 59  || $interval->format('%h') >= 1){
            return $interval->format('il reste %h heures');
        }if($interval->format('%s') > 59 || $interval->format('%i') >= 1 ){
            return $interval->format('il reste %i minutes');
        }if($interval->format('%i') > 59 ){
            return $interval->format('il reste %s secondes');
        }
    }

    public function calculDatePourcentage()
    {
        $date = new DateTime('NOW');

        $date_from = $this->requ_date_creation;
        $date1 = new DateTime($date_from);

        $date_to = $this->requ_date_to;
        $date2 = new DateTime($date_to);
        $date2->setTime(23,59,59);

        $interval1 = $date1->diff($date2);
        $diff_sec1 = $interval1->format('%r').(
                ($interval1->s)+
                (60*($interval1->i))+
                (60*60*($interval1->h))+
                (24*60*60*($interval1->d))+
                (30*24*60*60*($interval1->m))+
                (365*24*60*60*($interval1->y))
            );


        $interval = $date->diff($date2);

        $diff_sec = $interval->format('%r').( // prepend the sign - if negative, change it to R if you want the +, too
                ($interval->s)+ // seconds (no errors)
                (60*($interval->i))+ // minutes (no errors)
                (60*60*($interval->h))+ // hours (no errors)
                (24*60*60*($interval->d))+ // days (no errors)
                (30*24*60*60*($interval->m))+ // months (???)
                (365*24*60*60*($interval->y)) // years (???)
            );


        $total = $diff_sec1 - $diff_sec;
        $result = ($total / $diff_sec1) * 100;
        return $result;

    }
}

