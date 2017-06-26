<style type="text/css">
    .photo img{
    width:100px;
        height:100px;
        -webkit-border-radius: 5px;
        -webkit-border-bottom-right-radius: 0;
        -moz-border-radius: 5px;
        -moz-border-radius-bottomright: 0;
        border-radius: 5px;
        border-bottom-right-radius:0;
        -moz-box-shadow: 0px 5px 0px 0px #9bd2d6;
    -webkit-box-shadow: 0px 10px 0px 0px #9bd2d6;
    -o-box-shadow: 0px 5px 0px 0px #9bd2d6;
        box-shadow: 0px 5px 0px 0px #9bd2d6;
        filter:progid:DXImageTransform.Microsoft.Shadow(color=#e6e6e6, Direction=180, Strength=5);
    }


</style>





<div class='col-md-18'>
    <?php
    $page = $_POST['page'];
    $communities = explode(',', $_POST['listecomm']);
    $rqCommunities = '';
    if($communities[0]!='') {
        for ($i = 0; $i < sizeof($communities); $i++) {
            if ($i == 0 && $i != sizeof($communities)) $rqCommunities .= 'AND ( shac_comm_id =' . $communities[$i];
            else $rqCommunities .= ' OR shac_comm_id =' . $communities[$i];
            if ($i == sizeof($communities) - 1) $rqCommunities .= ')';
        }
        //echo $rqCommunities;
        $article = DB::SqlToObj(array('product', 'article'), "SELECT DISTINCT prod_id,arti_pictures,arti_price,prod_name FROM product,article,share_community WHERE prod_id = arti_prod_id AND arti_pictures != '[]' " . $rqCommunities . " AND shac_prod_id = arti_prod_id ORDER BY prod_date_creation DESC");
        $nbPages = ceil(sizeof($article) / 4) - 1;
        if ($article != null) {
            if ($nbPages == 0) $page = 0;
            while ($page < 0) $page = ($page + $nbPages) % $nbPages + 1;
            while ($page > $nbPages) $page = $page % ($nbPages + 1);

            for ($i = 0; $i < 4; $i++) {
                $compteur = $i + $page * 4;
                ?>
                <a class='col-md-9 carr_link_class' style="padding: 5px;height: 140px;"
                   id='carr_link_<?php echo $compteur ?>'
                   href='/view/<?php echo $article[$compteur][0]->getAttr('id'); ?>'>
                    <div class='col-md-18 photo' style='padding:0px;margin-bottom: 40px;'>
                        <div style='position:relative;width:100%;border-radius: 10px'>
                            <?php echo $article[$compteur][1]->print_picture(100, '', '', '0'); ?>
                            <div
                                style='display: none; color:white;height:100px;width:100px;position:absolute;top:0px;left:0px;opacity:0.8;background-color:#00a2b0;-webkit-border-radius: 5px;-webkit-border-bottom-right-radius: 0;-moz-border-radius: 5px;-moz-border-radius-bottomright: 0;border-radius: 5px;border-bottom-right-radius: 0;'
                                id='carr_hover_<?= $i ?>'>
                                <div class='col-md-18' style='padding: 0;'>
                                    <div class='col-md-18' id='carr_price_<?php echo $compteur ?>' style="padding: 0;">
                                        <div
                                            style=" position: absolute;top: 15px;left: 36px;font-size: 25px;z-index: 9999;font-family: bariolBold;">
                                            <?php echo $article[$compteur][1]->getMutumByDay(); ?>
                                        </div>
                                        <div class="col-md-18">
                                            <img src="/img/pile-money-02.png" alt=""
                                                 style="width: 50px;height: 50px;box-shadow: none;margin-left: 15px;margin-top: 5px;"/>
                                        </div>
                                        <div class="col-md-18" style="margin-left: 20px;font-size: 20px;">
                                            /jour
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-18"
                                 style="padding:0;text-align: center;color:#01b8c8;font-size: 12px;font-family: bariolRegular;margin-top: 10px;overflow: hidden">
                                <?php echo $article[$compteur][0]->getAttr('name'); ?>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
                if ($compteur + 1 >= sizeof($article)) $i = 4000;// on sort de la boucle si y a plus assez d'objet
            }
        }
        else echo 'Aucun objet &agrave afficher';
    }
    else echo 'Aucun objet &agrave afficher';
    ?>
</div>


























