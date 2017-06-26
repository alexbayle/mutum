

<?php
    //echo $_POST['page'];
    //echo sizeof($lesMieuxNotés);
    $page=$_POST['page'];

    switch ($_POST['categorie']) {
        case '#rand100':

            $article = DB::SqlToObj(array('product','article'),"SELECT * FROM product,article WHERE prod_id = arti_prod_id AND arti_pictures != '[]' ORDER BY RAND() LIMIT 19 ");
            if($article!=null) {
                for ($i = 0; $i < 12; $i++) {
                    ?>
                    <a class='col-md-3 col-sm-3 carr_link_class' style="padding: 5px;height: 175px;"
                       id='carr_link_<?php echo $i?>'
                       href='<?php WEBDIR ?>view/<?php echo $article[$i][0]->getAttr('id'); ?>'>
                        <div class='col-md-18 col-sm-18 photo' style='padding:0px;margin-bottom: 40px;'>
                            <div style='position:relative;width:100%;border-radius: 10px'>
                                <div class="xs-hidden tel-hidden sm-hidden">
                                <?php echo $article[$i][1]->print_picture(100, '', '', '0'); ?>
                                </div>
                                <div class="xs-hidden tel-hidden md-hidden">
                                    <?php echo $article[$i][1]->print_picture(75, '', '', '0'); ?>
                                </div>
                                <div
                                    style='display: none; color:white;height:100px;width:100px;position:absolute;top:0px;left:0px;opacity:0.8;background-color:#00a2b0;-webkit-border-radius: 5px;-webkit-border-bottom-right-radius: 0;-moz-border-radius: 5px;-moz-border-radius-bottomright: 0;border-radius: 5px;border-bottom-right-radius: 0;'
                                    id='carr_hover_<?= $i ?>'>
                                    <div class='col-md-18' style='padding: 0;'>
                                        <div class='col-md-18' id='carr_price_<?php echo $i ?>' style="padding: 0;">
                                            <div
                                                style=" position: absolute;top: <?php if($article[$i][1]->getAttr('price')<100) echo '15'; else echo '20';?>px;left: 36px;font-size:  <?php if($article[$i][1]->getAttr('price')<100) echo '25'; else echo '16';?>px;z-index: 1;font-family: bariolBold;">
                                                <?php echo $article[$i][1]->getMutumByDay();?>
                                            </div>
                                            <div class="col-md-18">
                                                <img src="<?= WEBDIR ?>img/pile-money-02.png" alt=""
                                                     style="width: 50px;height: 50px;box-shadow: none;margin-left: 15px;margin-top: 5px;"/>
                                            </div>
                                            <div class="col-md-18" style="margin-left: 20px;font-size: 20px;">
                                                /jour
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-18"
                                     style="padding:0;text-align: center;color:#01b8c8;font-size: 12px;font-family: bariolRegular;margin-top: 10px;">
                                    <?php echo $article[$i][0]->getAttr('name');?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
                }
            }
            break;

        case '#lesplusempruntes':
            $lesPlusEmpruntés = article::getLesPlusEmpruntés();
            $nbPages = ceil(sizeof($lesPlusEmpruntés)/12)-1;
            if($lesPlusEmpruntés!=null) {
                if($nbPages==0) $page = 0;
                while ($page < 0) $page = ($page + $nbPages) % $nbPages + 1;
                while ($page > $nbPages) $page = $page % ($nbPages + 1);
                for ($i = 0; $i < 12; $i++) {

                    $compteur = $i + $page * 12;
                    ?>
                    <a class='col-md-3 col-sm-3 carr_link_class' style="padding: 5px;height: 175px;"
                       id='carr_link_<?php echo $compteur?>'
                       href='<?php WEBDIR ?>view/<?php echo $lesPlusEmpruntés[$compteur][1]->getAttr('id'); ?>'>
                        <div class='col-md-18 photo' style='padding:0px;margin-bottom: 40px;'>
                            <div style='position:relative;width:100%;border-radius: 10px'>
                                <div class="xs-hidden tel-hidden sm-hidden">
                                    <?php echo $lesPlusEmpruntés[$compteur][2]->print_picture(100, '', '', '0'); ?>
                                </div>
                                <div class="xs-hidden tel-hidden md-hidden">
                                    <?php echo $lesPlusEmpruntés[$compteur][2]->print_picture(75, '', '', '0'); ?>
                                </div>

                                <div
                                    style='display: none; color:white;height:100px;width:100px;position:absolute;top:0px;left:0px;opacity:0.8;background-color:#00a2b0;-webkit-border-radius: 5px;-webkit-border-bottom-right-radius: 0;-moz-border-radius: 5px;-moz-border-radius-bottomright: 0;border-radius: 5px;border-bottom-right-radius: 0;'
                                    id='carr_hover_<?= $compteur ?>'>
                                    <div class='col-md-18' style='padding: 0;'>
                                        <div class='col-md-18' id='carr_price_<?php echo $compteur ?>'
                                             style="padding: 0;">
                                            <div
                                                style=" position: absolute;top: <?php if($lesPlusEmpruntés[$compteur][2]->getAttr('price')<100) echo '15'; else echo '20';?>px;left: 36px;font-size:  <?php if($lesPlusEmpruntés[$compteur][2]->getAttr('price')<100) echo '25'; else echo '16';?>px;z-index: 1;font-family: bariolBold;">
                                                <?php echo $lesPlusEmpruntés[$compteur][2]->getMutumByDay();?>
                                            </div>
                                            <div class="col-md-18">
                                                <img src="<?= WEBDIR ?>img/pile-money-02.png" alt=""
                                                     style="width: 50px;height: 50px;box-shadow: none;margin-left: 15px;margin-top: 5px;"/>
                                            </div>
                                            <div class="col-md-18" style="margin-left: 20px;font-size: 20px;">
                                                /jour
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-18"
                                     style="padding:0;text-align: center;color:#01b8c8;font-size: 12px;font-family: bariolRegular;margin-top: 10px;">
                                    <?php echo $lesPlusEmpruntés[$compteur][1]->getAttr('name');?>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                    if ($compteur + 1 >= sizeof($lesPlusEmpruntés)) $i = 4000;// on sort de la boucle si y a plus assez d'objet
                }
            }
            break;

        case '#lesmieuxnotes':
            $lesMieuxNotés = article::getLesMieuxNotés();
            $nbPages = ceil(sizeof($lesMieuxNotés)/12)-1;
            if($lesMieuxNotés!=null) {
                if($nbPages==0) $page = 0;
                while ($page < 0) $page = ($page + $nbPages) % $nbPages + 1;
                while ($page > $nbPages) $page = $page % ($nbPages + 1);
                for ($i = 0; $i < 12; $i++) {
                    $compteur = $i + $page * 12;
                    ?>
                    <a class='col-md-3 col-sm-3 carr_link_class' style="padding: 5px;height: 175px;"
                       id='carr_link_<?php echo $compteur?>'
                       href='<?php WEBDIR ?>view/<?php echo $lesMieuxNotés[$compteur][0]->getAttr('id'); ?>'>
                        <div class='col-md-18 photo' style='padding:0px;margin-bottom: 40px;'>
                            <div style='position:relative;width:100%;border-radius: 10px'>
                                <div class="xs-hidden tel-hidden sm-hidden">
                                    <?php echo $lesMieuxNotés[$compteur][1]->print_picture(100, '', '', '0'); ?>
                                </div>
                                <div class="xs-hidden tel-hidden md-hidden">
                                    <?php echo $lesMieuxNotés[$compteur][1]->print_picture(75, '', '', '0'); ?>
                                </div>

                                <div
                                    style='display: none; color:white;height:100px;width:100px;position:absolute;top:0px;left:0px;opacity:0.8;background-color:#00a2b0;-webkit-border-radius: 5px;-webkit-border-bottom-right-radius: 0;-moz-border-radius: 5px;-moz-border-radius-bottomright: 0;border-radius: 5px;border-bottom-right-radius: 0;'
                                    id='carr_hover_<?= $compteur ?>'>
                                    <div class='col-md-18' style='padding: 0;'>
                                        <div class='col-md-18' id='carr_price_<?php echo $compteur ?>'
                                             style="padding: 0;">
                                            <div
                                                style=" position: absolute;top: <?php if($lesMieuxNotés[$compteur][1]->getAttr('price')<100) echo '15'; else echo '20';?>px;left: 36px;font-size:  <?php if($lesMieuxNotés[$compteur][1]->getAttr('price')<100) echo '25'; else echo '16';?>px;z-index: 1;font-family: bariolBold;">
                                                <?php echo $lesMieuxNotés[$compteur][1]->getMutumByDay();?>
                                            </div>
                                            <div class="col-md-18">
                                                <img src="<?= WEBDIR ?>img/pile-money-02.png" alt=""
                                                     style="width: 50px;height: 50px;box-shadow: none;margin-left: 15px;margin-top: 5px;"/>
                                            </div>
                                            <div class="col-md-18" style="margin-left: 20px;font-size: 20px;">
                                                /jour
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-18"
                                     style="padding:0;text-align: center;color:#01b8c8;font-size: 12px;font-family: bariolRegular;margin-top: 10px;">
                                    <?php echo $lesMieuxNotés[$compteur][0]->getAttr('name');?>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                    if ($compteur + 1 >= sizeof($lesMieuxNotés)) $i = 4000;// on sort de la boucle si y a plus assez d'objet
                }
            }


            break;

        case '#mesobjets':
            $compteuresObjets = article::getMesObjets();
            $nbPages = ceil(sizeof($compteuresObjets)/12)-1;
            if($compteuresObjets!=null) {
                if($nbPages==0) $page = 0;
                while ($page < 0) $page = ($page + $nbPages) % $nbPages + 1;
                while ($page > $nbPages) $page = $page % ($nbPages + 1);

                for ($i = 0; $i < 12; $i++) {
                    $compteur = $i + $page * 12;
                    ?>

                    <a class='col-md-3 col-sm-3 carr_link_class' style="padding: 5px;height: 175px;"
                       id='carr_link_<?php echo $compteur ?>'
                       href='<?php WEBDIR ?>view/<?php echo $compteuresObjets[$compteur][0]->getAttr('id'); ?>'>
                        <div class='col-md-18 photo' style='padding:0px;margin-bottom: 40px;'>
                            <div style='position:relative;width:100%;border-radius: 10px'>
                                <div class="xs-hidden tel-hidden sm-hidden">
                                    <?php echo $compteuresObjets[$compteur][1]->print_picture(100, '', '', '0'); ?>
                                </div>
                                <div class="xs-hidden tel-hidden md-hidden">
                                    <?php echo $compteuresObjets[$compteur][1]->print_picture(75, '', '', '0'); ?>
                                </div>

                                <div
                                    style='display: none; color:white;height:100px;width:100px;position:absolute;top:0px;left:0px;opacity:0.8;background-color:#00a2b0;-webkit-border-radius: 5px;-webkit-border-bottom-right-radius: 0;-moz-border-radius: 5px;-moz-border-radius-bottomright: 0;border-radius: 5px;border-bottom-right-radius: 0;'
                                    id='carr_hover_<?= $compteur ?>'>
                                    <div class='col-md-18' style='padding: 0;'>
                                        <div class='col-md-18' id='carr_price_<?php echo $compteur ?>'
                                             style="padding: 0;">
                                            <div
                                                style=" position: absolute;top: <?php if($compteuresObjets[$compteur][1]->getAttr('price')<100) echo '15'; else echo '20';?>px;left: 36px;font-size:  <?php if($compteuresObjets[$compteur][1]->getAttr('price')<100) echo '25'; else echo '16';?>px;z-index: 1;font-family: bariolBold;">
                                                <?php echo $compteuresObjets[$compteur][1]->getMutumByDay(); ?>
                                            </div>
                                            <div class="col-md-18">
                                                <img src="<?= WEBDIR ?>img/pile-money-02.png" alt=""
                                                     style="width: 50px;height: 50px;box-shadow: none;margin-left: 15px;margin-top: 5px;"/>
                                            </div>
                                            <div class="col-md-18" style="margin-left: 20px;font-size: 20px;">
                                                /jour
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-18"
                                     style="padding:0;text-align: center;color:#01b8c8;font-size: 12px;font-family: bariolRegular;margin-top: 10px;">
                                    <?php echo $compteuresObjets[$compteur][0]->getAttr('name'); ?>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                    if ($compteur + 1 >= sizeof($compteuresObjets)) $i = 4000;// on sort de la boucle si y a plus assez d'objet
                }


            }
            break;

        default:
            echo 'Erreur AJAX afficherObjetsCaroussel';
            break;
    }
    


    




