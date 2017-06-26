<?php

class post extends root
{

    //Attributs
    public $post_id;
    public $post_user_id;
    public $post_cat;
    public $post_requ_id;
    public $post_text;
    public $post_date_creation;
    public $post_deleted;
    public $post_nb_like;
    public $post_nb_comment;
    public $post_community;
    public $post_favorite;

    public static $pref = 'post_';
    public static $exclusion = array('post_nb_like', 'post_nb_comment', 'post_community', 'post_favorite');


    //Fonctions

    public function print_post($listecomm, $name)
    {
        $tab_comm = explode(',', $listecomm);
        ?>
        <div class='col-md-18 post boxshadow <?= ($name == 'favoris' ? "colorfavoris" : "") ?>'
             id='post_block_<?= $this->getAttr('id') ?>'>
            <div class='col-md-3 post_img'>
                <?php
                if ($this->getAttr('user_id') == null) {
                    echo community::getACommunity($this->getAttr('community'))[0][0]->print_avatar(80);
                } else {
                    echo $this->getAttr('user_id')->print_user(80);
                }
                ?>
            </div>
            <div class='col-md-14 post_description' style="padding: 0;">
                <div class='col-md-18 post_text' style="padding: 0;">
                    <?php
                    switch ($this->getAttr('cat')) {
                        case '1': //wishlist
                            $post = post::getAllByPost($this->post_id);
                            //var_dump($post);
                            echo "<span class='blue bold'>" . $this->getAttr('user_id')->printName() . "</span> cherche : <span class='darkgrey bold'>" . $this->getAttr('text') . "</span> pour le <span class='darkgrey bold'>" . ($post[0][1]->getAttr('date')) . "</span>.";
                            break;
                        case '2': //new_article
                            echo "<span class='blue bold'>" . $this->getAttr('user_id')->printName() . "</span> vient de mettre en ligne : <span class='darkgrey bold'>" . $this->getAttr('text') . "</span>.";
                            break;
                        case '3': //new_actu
                            echo "<span class='blue bold'>" . community::getACommunity($this->getAttr('community'))[0][0]->getAttr('name') . "</span> a ajouté une nouvelle actualité : " . $this->getAttr('text') . ".";
                            break;
                        case '4': //new_user
                            echo "<span class='blue bold'>" . $this->getAttr('user_id')->printName() . "</span> viens de rejoindre la communauté <span class='darkgrey bold'>" . $this->getAttr('text') . "</span>.";
                            break;
                        case '5': //new_loan
                            echo "<span class='blue bold'>" . $this->getAttr('user_id')->printName() . "</span> a emprunté un objet : <span class='darkgrey bold'>" . $this->getAttr('text') . "</span>.";
                            break;
                        case '6': //new_loan
                            echo "<span class='blue bold'>" . $this->getAttr('user_id')->printName() . "</span> a prété son objet : <span class='darkgrey bold'>" . $this->getAttr('text') . "</span>.";
                            break;
                        case '9': //message
                            if ($this->getAttr('user_id') == null) {echo "<span class='blue bold'>" . community::getACommunity($this->getAttr('community'))[0][0]->getAttr('name');
                            } else {
                                echo "<span class='blue bold'>" . $this->getAttr('user_id')->printName();
                            }
                            echo "</span> : " . $this->getAttr('text');
                            break;
                        case '7':
                            echo "<span class='blue bold'>" . $this->getAttr('user_id')->printName() . "</span> viens de rejoindre la communauté <span class='darkgrey bold'>" . $this->getAttr('text') . "</span>.";
                            break;
                        case '8':
                            echo "<span class='blue bold'>" . $this->getAttr('user_id')->printName() . "</span> viens de quitter la communauté <span class='darkgrey bold'>" . $this->getAttr('text') . "</span>.";
                            break;
                        default:
                            echo "error";
                            break;
                    }
                    ?>
                </div>
            </div>
            <div class='col-md-14 post_btn' style="padding: 0;padding-top: 9px;">
                <div style='float:left;' class='post_date' id='date_<?= $this->getAttr('id') ?>'>il y
                    a <?= $this->calculPostDate() ?></div>
                <div style='float:left;' class='jaime' id='like_<?= $this->getAttr('id') ?>'>
                    <?php
                    if ($this->islike()) {
                        echo "dislike ";
                    } else {
                        echo "j'aime ";
                    }
                    echo "(" . $this->getAttr('nb_like') . ")";
                    ?>
                </div>
                <div style='float:left;' class='commenter' id='comment_<?= $this->getAttr('id') ?>'>commenter
                    (<?= $this->getAttr('nb_comment') ?>)
                </div>

                <?php
                    switch ($this->getAttr('cat')) {
                        case '1': //wishlist
                            echo "<div style='float:left;' class='postCatButton' id='postCatButton2" . $this->getAttr(
                                    'id') . "' >je l'ai !</div>";
                            break;
                        case '2':

                            break;
                        case '3':

                            break;
                        case '4':

                            break;
                        case '5':

                            break;
                        case '6':

                            break;
                        case '7':
                            echo "<div style='float:left;' class='postCatButton' id='postCatButton7" . $this->getAttr(
                                    'id') . "' >bienvenue !</div>";
                            break;
                        case '8':
                            echo "<div style='float:left;' class='postCatButton' id='postCatButton8" . $this->getAttr(
                                    'id') . "' >aurevoir !</div>";
                            break;
                        default:

                            break;
                    }
                ?>

            </div>
            <div class='col-md-1 post_fav' style="padding: 0;">
                <div style='float: left;position: absolute;top: 12px;right: 23px;' id='post_fav_<?= $this->getAttr('id') ?>'>
                    <?php
                    if ($this->isfavorite() == 1) {
                        echo "<img src='" . WEBDIR . "img/star.png' class='favorite' id='favorite_" . $this->getAttr('id') . "'>";
                    } else {
                        echo "<img src='" . WEBDIR . "img/empty_star.png' class='favorite' id='favorite_" . $this->getAttr('id') . "'>";
                    }
                    ?>
                </div>
                <div style='float: left;position: absolute;top: 10px;right: 10px;'>
                    <img src='<?= WEBDIR ?>img/community/menu.png' alt=''/>
                </div>
            </div>
            <div class='post_figure'>
                <?php $tab_all_comm = community::getMyListeComm(); ?>
                <?php //var_dump($tab_all_comm); ?>

                <img src='<?= WEBDIR ?>img/community/triangle_<?php echo array_search($this->getCommunityByPost($this->post_id)[0][2]->getAttr('table_id'),$tab_all_comm) ?>.png' alt=''/>
            </div>
        </div>
        <div class='col-md-18 post_comment' id='post_comment_<?= $this->getAttr('id') ?>'>
        </div>
    <?php
    }


    public function calculPostDate()
    {
        $datedujour = new DateTime();
        $datedupost = new DateTime($this->getAttr('date_creation'));
        $interval = $datedupost->diff($datedujour);

        if ($interval->format('%d') > 30) {
            return $interval->format('%m mois');
        } else {
            if ($interval->format('%h') > 24 || $interval->format('%d') >= 1) {
                return $interval->format('%d jours');
            } else {
                if ($interval->format('%i') > 59 || $interval->format('%h') >= 1) {
                    return $interval->format('%h heures');
                } else {
                    if ($interval->format('%s') > 59 || $interval->format('%i') >= 1) {
                        return $interval->format('%i minutes');
                    } else {
                        if ($interval->format('%s') > 59) {
                            return $interval->format('%s secondes');
                        } else {
                            return "<span style='font-size:13px'>quelques instants</span>";
                        }
                    }
                }
            }
        }
    }


    public function printFavorite()
    {
        if ($this->getAttr('favorite') == 1) {
            return "<img src='" . WEBDIR . "img/star.png' class='favorite' id='favorite_" . $this->getAttr('id') . "'>";
        } else {
            return "<img src='" . WEBDIR . "img/empty_star.png' class='favorite' id='favorite_" . $this->getAttr('id') . "'>";
        }
    }

    public static function checkAllowed($id)
    {
        if (DB::SqlOne(
                "select count(*)
              from post,limitation,limitation_field,join_community
              where post_id='$id'
              and post_id=limi_post_id
              and limi_id=limf_limi_id
              and limf_table_id=join_comm_id
              and join_user_id='" . Session::Me()->getAttr('id') . "'"
            ) > 0
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function islike()
    {
        if (DB::SqlOne(
                "select count(*)
                    from like_post
                    where likp_post_id='" . $this->getAttr('id') . "'
                    and likp_user_id='" . Session::Me()->getAttr('id') . "'"
            ) > 0
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function switchlike()
    {
        if ($this->islike()) {
            DB::sqlExec(
                "delete
                    from like_post
                    where likp_user_id='" . Session::Me()->getAttr('id') . "'
                    and likp_post_id='" . $this->getAttr('id') . "'"
            );

            return 'dislike';
        } else {
            $like = new like_post();
            $like->setAttr('user_id', Session::Me()->getAttr('id'));
            $like->setAttr('post_id', $this->getAttr('id'));
            $like->Insert();

            return 'like';
        }
    }

    public function nblike()
    {
        return DB::SqlOne("select count(*) from like_post where likp_post_id='" . $this->getAttr('id') . "'");
    }

    public function isfavorite()
    {
        if (DB::SqlOne(
                "select count(*) from favorite_post where favp_post_id='" . $this->getAttr(
                    'id'
                ) . "' and favp_user_id='" . Session::Me()->getAttr('id') . "'"
            ) > 0
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function switchfavorite()
    {
        if ($this->isfavorite()) {
            DB::sqlExec(
                "delete from favorite_post where favp_user_id='" . Session::Me()->getAttr(
                    'id'
                ) . "' and favp_post_id='" . $this->getAttr('id') . "'"
            );
            $this->setAttr('favorite', '0');
        } else {
            $favorite = new favorite_post();
            $favorite->setAttr('user_id', Session::Me()->getAttr('id'));
            $favorite->setAttr('post_id', $this->getAttr('id'));
            $favorite->Insert();
            $this->setAttr('favorite', '1');
        }
    }


    public static function createFromUserJoinCommunity(user $user, community $community)
    {
        $post = new \post();
        $post->post_user_id = $user->getAttr('id');
        $post->post_text = $community->getAttr('name');
        $post->post_cat = 7; // user_join_community
        $post->post_date_creation = date('Y-m-d H:i:s');
        $post->post_deleted = false;
        $postId = $post->Insert();


        $limitation = new \limitation();
        $limitation->limi_post_id = $postId;
        $limitation->limi_id = $limitation->Insert();

        $limitationField = new \limitation_field();
        $limitationField->limf_table_id = $community->getAttr('id');
        $limitationField->limf_type = 2;
        $limitationField->limf_limi_id = $limitation->limi_id;
        $limitationField->Insert();
    }


    public static function createFromUserLeaveCommunity(user $user, community $community)
    {
        $post = new \post();
        $post->post_user_id = $user->getAttr('id');
        $post->post_text = $community->getAttr('name');
        $post->post_cat = 8; // user_leave_community
        $post->post_date_creation = date('Y-m-d H:i:s');
        $post->post_deleted = false;
        $postId = $post->Insert();


        $limitation = new \limitation();
        $limitation->limi_post_id = $postId;
        $limitation->limi_id = $limitation->Insert();

        $limitationField = new \limitation_field();
        $limitationField->limf_table_id = $community->getAttr('id');
        $limitationField->limf_type = 2;
        $limitationField->limf_limi_id = $limitation->limi_id;
        $limitationField->Insert();
    }

    public static function createFromLoanBorrowed(product $product, user $user, request $request)
    {
        $post = new \post();
        $post->post_user_id = $user->getAttr('id');
        $post->post_text = $product->getAttr('name');
        $post->post_cat = 5; // new_loan_borrower
        $post->post_date_creation = date('Y-m-d H:i:s');
        $post->post_deleted = false;
        $post->post_requ_id = $request->getAttr('id');
        $post->setAttr('id', $post->Insert());

        foreach ($product->getCommunities() as $community) {
            $community = $community[0];

            $limitation = new \limitation();
            $limitation->limi_post_id = $post->getAttr('id');
            $limitation->limi_id = $limitation->Insert();

            $limitationField = new \limitation_field();
            $limitationField->limf_table_id = $community->getAttr('id');
            $limitationField->limf_type = 2;
            $limitationField->limf_limi_id = $limitation->limi_id;
            $limitationField->Insert();
        }
    }

    public static function createFromLoanLender(product $product, user $user, request $request)
    {
        $post = new \post();
        $post->post_user_id = $user->getAttr('id');
        $post->post_text = $product->getAttr('name');
        $post->post_cat = 6; // new_loan_lender
        $post->post_date_creation = date('Y-m-d H:i:s');
        $post->post_deleted = false;
        $post->post_requ_id = $request->getAttr('id');
        $post->setAttr('id', $post->Insert());


        foreach ($product->getCommunities() as $community) {
            $community = $community[0];

            $limitation = new \limitation();
            $limitation->limi_post_id = $post->getAttr('id');
            $limitation->limi_id = $limitation->Insert();

            $limitationField = new \limitation_field();
            $limitationField->limf_table_id = $community->getAttr('id');
            $limitationField->limf_type = 2;
            $limitationField->limf_limi_id = $limitation->limi_id;
            $limitationField->Insert();
        }
    }

    private function getCommunityByPost($post_id){
       return DB::SqlToObj(array('post','limitation','limitation_field'),"
                SELECT *
                FROM `post`,`limitation`,`limitation_field`
                WHERE post_id = limi_post_id
                AND limi_id = limf_limi_id
                AND `post_id` = '".$post_id."'
                ");
    }

    public static function getAllByPost($post_id){
        return DB::SqlToObj(array('post','wishlist','virtual_product','virtual_article','limitation','limitation_field'),"
        Select *
        From post, wishlist, virtual_product, virtual_article, limitation, limitation_field
        Where post.post_id = wishlist.wish_post_id
        And wishlist.wish_virp_id = virtual_product.virp_id
        And virtual_product.virp_id = virtual_article.vira_virp_id
        And post.post_id = limitation.limi_post_id
        And limitation.limi_id = limitation_field.limf_limi_id
        And post.post_id = '".$post_id."'
        ");
    }
}