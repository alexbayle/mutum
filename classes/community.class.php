<?php

class community extends root
{

    //Attributs
    public $comm_id;
    public $comm_cat;
    public $comm_name;
    public $comm_desc;
    public $comm_address;
    public $comm_type;
    public $comm_type_data;

    public static $pref = 'comm_';

    //Fonctions

    public static function getAllCommunity()
    {
        return DB::SqlToObj(array('community'), "select * from " . DBPRE . "community");
    }

    public static function myComm(){
        return DB::SqlToArray("select comm_id from community,join_community where comm_id = join_comm_id and join_user_id=" . Session::Me()->getAttr('id') . "");
    }

    public static function getAllMyCommunity()
    {
        return DB::SqlToObj(
            array('community', 'community_cat', 'join_community'),
            "select * from " . DBPRE . "community, " . DBPRE . "join_community, " . DBPRE . "community_cat
            where comm_id = join_comm_id
            and comm_cat = comc_id
            and join_user_id=" . Session::Me()->getAttr('id') . "
            ORDER BY comm_id ASC"
        );

    }

    public static function getMyListeComm()
    {
        $tab = community::getAllMyCommunity();
        $liste = array();
        foreach ($tab as $t) {
            array_push($liste, $t[0]->getAttr('id'));
        }

        return $liste;
    }

    public static function getTotalNumberByComm($id_community)
    {
        return DB::SqlOne(
            "select count(join_user_id) from" . DBPRE . " join_community where join_comm_id = '$id_community'"
        );
    }

    public static function getTotalObjByComm($id_community)
    {
        return DB::SqlOne(
            "select count(shac_prod_id) from " . DBPRE . "share_community where shac_comm_id = '$id_community'"
        );
    }


    public static function getACommunity($id_community)
    {
        return DB::SqlToObj(array('community'), "select * from " . DBPRE . "community where comm_id = '$id_community'");
    }


    public static function printFilDactu($listecomm, $name, $limit, $offset)
    {
        //Attention, on utilise ici des objets wishlist dans tous les cas. On fait la diférence grace au post_cat (1 pour wishlist, pour autres cas voir la table)
        //Cependant pas de soucis, wishlist est fille de post, et getAttr et setAttr fonctionnent comme il faut en terme de préfixe d'attributs.

        if ($name == 'monactivite' || $name == 'affichertout') {
            ?>
            <div class="col-md-18 comment" style='margin-top:20px;'>
                <form action="" method="post">
                    <textarea name="commentaire" id="commentaire" cols="75" rows="6" placeholder="exprimez-vous..."></textarea>
                    <input type="submit" id="publier" name="publier" value="publier"/>
                    <div class="">
                        <select id="communities" name="communities_new_post" class="form-control multiple" multiple="multiple">
                            <?php foreach (community::getAllMyCommunity() as $community) : ?>
                                <option value="<?php echo $community[0]->getAttr('id') ?>"><?php echo $community[0]->getAttr('name') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <script>
                $("select.multiple").SumoSelect({
                    placeholder: 'Communauté(s)',
                    captionFormat: '{0} séléctionnés',
                    outputAsCSV:true
                });
            </script>
            <style>
                .SumoSelect {
                    display: inline-block;
                    position: absolute;
                    outline: none;
                    top: 68px;
                    /* width: 200px; */
                }
                .SumoSelect > .CaptionCont {
                    margin-left: 184px;
                }
            </style>
        <?php
        } elseif ($name == "demandes") {
            ?>
            <div class="demande" style='margin-top:20px;'>
                <form action="" method="post">
                    <div class="recherche boxshadow" style="height: 200px">
                        <div class="objcat col-md-9">
                            <label for="objrecherche">Objet recherché :</label><br/>
                            <input name="obj_wish" type="text"/>
                        </div>
                        <div class="objcat col-md-9">
                            <label for="communities">Communautés :</label><br/>
                            <select id="communities" name="communities_wish" class="form-control multiple" multiple="multiple">
                                <?php foreach (community::getAllMyCommunity() as $community) : ?>
                                    <option value="<?php echo $community[0]->getAttr('id') ?>"><?php echo $community[0]->getAttr('name') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="objcat col-md-9" style="margin-left: 1px">
                            <label for="category1">catégorie :</label>
                            <select id="category1" class="chain-select" data-child="#category2" name="cat_wish">
                                <?php echo Site::combo_contents(category_article::getMainList(), $article->art_cat, "cata_id", "cata_name"); ?>
                            </select>

                            <div class="demande_item" style="display:none;">
                                <label for="category2">catégorie 2 :</label>
                                <select id="category2" class="chain-select" data-child="#category3" name="art_cat_id2"></select>
                            </div>
                        </div>
                        <div class="objcat col-md-9" style="margin-left: -1px">
                            <label for="date">Date :</label><br/>
                            <input id="date" type="text" name="date_wish"/>
                        </div>
                        <div class="ok">
                            <input type="submit" name="community_wish" value="ok"/>
                        </div>
                    </div>
                </form>
                <div class="results">
                </div>
            </div>
            <script>
                $('#date').datetimepicker({
                    timepicker:false,
                    formatDate:'Y/m/d',
                    lang:'fr',
                    format:'Y/m/d'
                });

                $("select.multiple").SumoSelect({
                    placeholder: 'Séléctionnez vos communautés',
                    captionFormat: '{0} séléctionnés',
                    outputAsCSV:true
                });

                $('.chain-select').on('change', function(e) {
                    e.preventDefault();

                    var me = this,
                        child = $(this).data('child');

                    $.ajax({
                        url: "/<?php echo AJAXLOAD ?>category",
                        data: {method: 'getChildren', category_id: $(this).val()},
                        dataType: 'json',
                        type: 'POST',
                        success: function(data) {
                            if (data.success == true) {
                                $(child).html('');
                                if ($(child).data('child')) {
                                    $($(child).data('child')).html('');
                                }

                                if (data.datas.length) {
                                    $(child).append('<option value=""></option>');
                                }
                                $.each(data.datas, function (k, category) {
                                    $(child).append('<option value="' + category.cata_id + '">' + category.cata_name + '</option')
                                });

                                $.each($('.chain-select'), function(k, v) {
                                    if ($(v).html()) {
                                        $(v).parent().show();
                                    } else {
                                        $(v).parent().hide();
                                    }
                                });

                            } else {
                                console.log('erreur');
                            }
                        }
                    });
                });

            </script>
        <?php
        }


        if ($listecomm != '') {
            $tab_post = community::filActu($listecomm, $name, $limit, $offset);
//            var_dump($tab_post);
            if (sizeof($tab_post) == 0) {
                echo "Pas ou plus de posts";
            } else {
                foreach ($tab_post as $tab) {
                    //Inclusion de user dans wishlist, sauf si user_id est deja null
                    if ($tab[0]->getAttr('user_id') != null) {
                        $tab[0]->setAttr('user_id', $tab[1]);
                    }

                    //Inclusion de virtual_product dans post, sauf si wish_virp_id est deja null
                    if ($tab[0]->getAttr('virp_id') != null) {
                        $tab[0]->setAttr('virp_id', $tab[2]);
                    }

                    //Affichage du post
                    switch (get_class($tab[0])) {
                        case 'post':
                            //var_dump($tab[0]);
                            $tab[0]->print_post($listecomm, $name);
                            break;
                        case 'request':
                            //var_dump($tab); die;
                            $tab[0]->print_request($listecomm, $name);
                            break;
                        default:
                            var_dump(sprintf("You should implement %s.", get_class($tab[0])));
                    }
                }
            }
        } else {
            echo "Cette page n'affichera rien si vous ne sélectionnez pas de communauté !";
        }
    }

    public static function filActu($listcomm, $name, $limit=10, $offset=0)
    {
        if (Session::Online()) {
            $error = false;
            $community = explode(",", $listcomm);
            foreach ($community as $c) {
                if (!self::checkmember($c)) {
                    $error = true;
                }
            }

            if (!$error) {

                switch ($name) {
                    case 'affichertout':
                        $query = sprintf(
                            "
                            SELECT p.*,  l.*, lf.*, u.*, r.*
                            FROM post p
                            INNER JOIN limitation l ON l.limi_post_id=p.post_id
                            INNER JOIN limitation_field lf ON lf.limf_limi_id=l.limi_id
                            LEFT JOIN request r ON r.requ_id=p.post_requ_id
                            LEFT JOIN user u ON u.user_id=p.post_user_id
                            WHERE lf.limf_table_id IN (%s)
                            GROUP BY p.post_id
                            ORDER BY p.post_date_creation DESC
                            LIMIT $limit OFFSET $offset",
                            $listcomm

                        );
//                        print_r($query); die;
                        return DB::SqlToObj(array('post', 'user'), $query);
                        break;

                    case 'demandes':
                        $query = sprintf(
                            "
                            SELECT p.*, u.*
                            FROM post p
                            INNER JOIN limitation l ON p.post_id=l.limi_post_id
                            INNER JOIN limitation_field lf ON lf.limf_limi_id=l.limi_id
                            INNER JOIN user u ON u.user_id=p.post_user_id
                            WHERE lf.limf_table_id IN (%s)
                            AND p.post_cat = 1
                            GROUP BY p.post_id
                            ORDER BY p.post_date_creation DESC
                            LIMIT $limit OFFSET $offset",
                            $listcomm
                        );

                        return DB::SqlToObj(array('post', 'user'), $query);
                        break;

                    case 'dernierspret':
                        $query = sprintf(
                            "
                            SELECT p.*, u.*
                            FROM post p
                            INNER JOIN limitation l ON p.post_id=l.limi_post_id
                            INNER JOIN limitation_field lf ON lf.limf_limi_id=l.limi_id
                            INNER JOIN user u ON u.user_id=p.post_user_id
                            INNER join request r ON r.requ_id=p.post_requ_id AND r.requ_lender_id=u.user_id
                            WHERE lf.limf_table_id IN (%s)
                            ORDER BY p.post_date_creation DESC
                            LIMIT $limit OFFSET $offset",
                            $listcomm
                        );
                        return DB::SqlToObj(array('post', 'user'), $query);
                        break;
                    case 'favoris':
                        $query = sprintf(
                            "
                            SELECT DISTINCT p.*, u.*
                            FROM post p
                            INNER JOIN limitation l ON p.post_id=l.limi_post_id
                            INNER JOIN limitation_field lf ON lf.limf_limi_id=l.limi_id
                            INNER JOIN user u ON u.user_id=p.post_user_id
                            INNER join favorite_post f ON f.favp_post_id=p.post_id AND f.favp_user_id=u.user_id
                            WHERE lf.limf_table_id IN (%s)
                            ORDER BY p.post_date_creation DESC
                            LIMIT $limit OFFSET $offset",
                            $listcomm
                        );
                        return DB::SqlToObj(array('post', 'user'), $query);
                        break;
                    case 'monactivite':
                        $query = sprintf(
                            "
                            SELECT p.*, u.*
                            FROM post p
                            LEFT JOIN limitation l ON p.post_id=l.limi_post_id
                            LEFT JOIN limitation_field lf ON lf.limf_limi_id=l.limi_id
                            LEFT JOIN user u ON u.user_id=p.post_user_id
                            %s
                            WHERE lf.limf_table_id IN (%s)
                            AND u.user_id='%s'
                            GROUP BY p.post_id
                            ORDER BY p.post_date_creation DESC
                            LIMIT $limit OFFSET $offset",
                            "LEFT JOIN request r ON r.requ_prod_id=p.post_id",
//                            LEFT JOIN wishlist w ON p.post_id=w.wish_post_id
//                            LEFT JOIN virtual_product vp ON w.wish_virp_id=vp.virp_id
                            $listcomm,
                            \Session::Me()->getAttr('id')

                        );



                        return DB::SqlToObj(array('post', 'user'), $query);
                        break;

                        break;
                    default:
                        throw new \Exception(sprintf("Action %s not found.", $name));
                }
            } else {
                echo "Error: vous n'êtes pas dans ces communautés.";
            }
        } else {
            echo "error";
        }
    }

    public static function checkmember($value)
    {
        $res = DB::SqlOne(
            "select count(*) from join_community where join_user_id = " . Session::Me()->getAttr(
                'id'
            ) . " and join_comm_id = " . $value . ""
        );
        if ($res > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getMyActu($listcomm, $limit, $offset)
    {

        $user = Session::Me()->getAttr('id');

        if ($user) {
            return DB::SqlToArray(
                "select post.*,user.*,
            (select count(*) as 'nb de commentaire' from comment_post where comp_post_id=post_id),
            (select count(*) as 'nb de like' from like_post where likp_post_id=post_id)
            from post, limitation, limitation_field, user
            where post_id = limi_post_id
            and limi_id = limf_limi_id
            and post_user_id = user_id
            and limf_table_id =" . $listcomm . "
            and limf_type = 2
            and user_id =" . Session::Me()->getAttr('id') . "
            order by post_date_creation
            limit " . $limit . "
            offset " . $offset . "
            "
            );
        } else {
            return 'error';
        }

    }

    public static function getMyWish($listcomm, $limit, $offset)
    {
        $user = Session::Me()->getAttr('id');

        if ($user) {
            return DB::SqlToArray(
                "select post.*,user.*,
            (select count(*) as 'nb de commentaire' from comment_post where comp_post_id=post_id),
            (select count(*) as 'nb de like' from like_post where likp_post_id=post_id)
            from post, limitation, limitation_field, user
            where post_id = limi_post_id
            and limi_id = limf_limi_id
            and post_user_id = user_id
            and limf_table_id =" . $listcomm . "
            and limf_type = 2
            and post_cat = 1
            order by post_date_creation
            limit " . $limit . "
            offset " . $offset . "
            "
            );
        } else {
            return 'error';
        }

    }

    public static function getLoan($listcomm, $limit, $offset)
    {
        $user = Session::Me()->getAttr('id');

        if ($user) {

        } else {
            return 'error';
        }

    }


    function print_avatar($size = 140, $class = "")
    {
        $id = Site::crypt_pwd($this->getAttr('id'));
        $src_path = "img/no-avatar-community.png";
        if (file_exists("img/community_avatar/$id.jpg")) {
            $src_path = "img/community_avatar/$id.jpg";
        } else {
            if (file_exists("img/community_avatar/$id.jpeg")) {
                $src_path = "img/community_avatar/$id.jpeg";
            } else {
                if (file_exists("img/community_avatar/$id.png")) {
                    $src_path = "img/community_avatar/$id.png";
                } else {
                    if (file_exists("img/community_avatar/$id.gif")) {
                        $src_path = "img/community_avatar/$id.gif";
                    }
                }
            }
        }

        return "<img src='" . WEBDIR . "$src_path' " . ($size != "" ? " style='height:" . $size . "px;width:" . $size . "px;'" : "") . " class='$class' >";
    }

    public static function findByName($name)
    {
        return DB::SqlOne(sprintf("SELECT * FROM community WHERE comm_name='%s';", $name));
    }

    public static function searchCommunity($community){
        return DB::SqlToArray("Select * from community where comm_name LIKE '%" . $community . "%' ");
    }

}
