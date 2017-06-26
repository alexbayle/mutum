
<?php include 'categoriesResponsives.php';?>
<div class='page'>
<div class='header'>
    <?php
    if(empty($_GET['page']))
    {?>
    <div class="header xs-hidden sm-hidden tel-hidden" style="width: 1070px;opacity:0.6;height: 120px;position: absolute; opacity: 0.3;   z-index: 80;background-color: black;"></div>
    <?php } ?>
<div class='col-md-18 top' style="z-index: 99;">

<div class='col-md-6 identity' id='identity'>
    <div class='logo'>
        <a href='<?=WEBDIR?>'><img src='<?=WEBDIR?>img/header_logo.png' id='header_logo' class='header_logo' style='width:100%;'></a>
    </div>
    <div class='slogan tel-hidden'>
        <a style="<?php if(!empty($_GET['page'])) echo "color:#00A2B0" ?>" href='<?=WEBDIR?>'>plus on partage,<br /><span style=''>plus on possède !</span></a>
    </div>
</div>

<div class='col-md-12 col-sm-18 col-xs-18 container'>
    <div class='menu <?php if(!Session::Online()) echo 'menuAnonyme';?>'>

        <?php
        if(Session::Online())
        {
            ?>
            <div class="cell sociaux">
                <ul>
                    <li class="tel-hidden xs-hidden"><a href="https://www.facebook.com/pages/Mutum/279346655546671" target="_blank"><img src="<?=WEBDIR?>img/picto/fb.png" style="width: 22px" alt=""/></a></li>
                    <li class="tel-hidden xs-hidden"><a href="https://twitter.com/mutum_fr" target="_blank"><img src="<?=WEBDIR?>img/picto/twitter.png" style="width: 22px" alt=""/></a></li>
                    <li class="xs-hidden tel-hidden"><a href="http://instagram.com/mutum_fr" target="_blank"><img src="<?=WEBDIR?>img/picto/instagram.png" style="width: 22px" alt=""/></a></li>
                    <li class="xs-hidden tel-hidden"><a href="https://fr.pinterest.com/mutum_fr" target="_blank"><img src="<?=WEBDIR?>img/picto/pinterest.png" style="width: 22px" alt=""/></a></li>
                </ul>
            </div>
            <div class='cell parrain'>
                <a href='<?=WEBDIR?>sponsor'><button type='button' class='btn header <?php if(empty($_GET)) echo "accueil"?>'>parrainez un ami</button></a>
            </div>

            <div class='cell noborder pret'>
                <a href='<?=WEBDIR?>new'><button type='button' class='btn header <?php if(empty($_GET)) echo "accueil"?>'>prêtez <span class=" tel-hidden">un objet</span></button></a>
            </div>

            <div class='cell noborder userMoney xs-hidden tel-hidden' style="width: 74px">
                <a href='<?=WEBDIR?>success/wallet'>
                    <div class='credit_info'>
                        <?=Session::Me()->getAttr('credit');?>
                    </div>
                    <div class='credit_img'>
                        <img src='<?=WEBDIR?>img/header_number_mutum.png' style='width:17px;height: 17px'>
                    </div>
                </a>
            </div>

            <div class='cell noborder tel-hidden xs-hidden'>
                <a href='<?=WEBDIR?>success/list'>
                    <div class='progress_img'>
                        <img src=<?=user::linkAvatarImg(Session::Me()->user_id,Session::Me()->user_rank)?> style='width:100%;'>
                    </div>
                    <div class='progress_info'>
                        <div class='progress_number'><?php echo count(\achievements::getMyOwnAchievementsByCat(\Session::Me()->user_id)) ?>/<?php echo achievements::countAchievementsByCat() ?> succès</div>
                        <div class="successAccueil">
                            <progress  value="<?php echo count(\achievements::getMyOwnAchievementsByCat(\Session::Me()->user_id)); ?>" max="<?php echo achievements::countAchievementsByCat() ?>" form="form-id"></progress>
                        </div>
                        <div class='progress_alt'>progression</div>
                    </div>
                </a>
            </div>

            <div class='cell tel-hidden xs-hidden' id='cell_menu' style='position:relative;'>
                <div class='menu_name tel-hidden'>
                    <?php $nom = Session::Me()->getAttr('lastname');?>
                    <?=Session::Me()->getAttr('firstname');?>
                    <?= strtoupper($nom[0]); ?>
                </div>
                <div class='menu_img'>
                    <div class="menu_avatar">
                        <?php echo Session::Me()->print_user('40') ?>
                    </div>
                    <div class='menu_arrow'>
                        <img src="<?=WEBDIR?>img/whitearrowdown.png" style="width: 10px;"/>
                    </div>
                    <div class='notification' style="display: none;">
                        1
                    </div>
                </div>
                <div class='menu_user' id='menu_user'>
                    <div class='trans'></div>
                    <div class='menu_list <?php if(empty($_GET['page'])) echo "accueil"?>'>
                        <ul>
                            <a href='<?=WEBDIR?>profile'><li style="border-top: none;"><img src="<?=WEBDIR?>img/menu/<?php if(empty($_GET)) echo 'blanc'; else echo 'gris';?>/icon_menu-05.png" style="position: absolute;left: 10px;width: 20px;"/>mon compte</li></a>
                            <a href='<?=WEBDIR?>items'><li style=''><img src="<?=WEBDIR?>img/menu/<?php if(empty($_GET)) echo 'blanc'; else echo 'gris';?>/icon_menu-09.png" style="position: absolute;left: 10px;width: 20px"/>mes objets</li></a>
                            <a href='<?=WEBDIR?>loan'><li style=''><img src="<?=WEBDIR?>img/menu/<?php if(empty($_GET)) echo 'blanc'; else echo 'gris';?>/icon_menu-08.png" style="position: absolute;left: 10px;width: 20px"/>mes prêts / emprunts</li></a>
                            <a href='<?=WEBDIR?>community'><li style=''><img src="<?=WEBDIR?>img/menu/<?php if(empty($_GET)) echo 'blanc'; else echo 'gris';?>/icon_menu-06.png" style="position: absolute;left: 10px;width: 20px"/>mes communautés</li></a>
                            <a href='<?=WEBDIR?>wishlist'><li style=''><img src="<?=WEBDIR?>img/menu/<?php if(empty($_GET)) echo 'blanc'; else echo 'gris';?>/icon_menu-02.png" style="position: absolute;left: 10px;width: 20px"/>liste de souhaits</li></a>
                            <a href='<?=WEBDIR?>contact'><li style=''><img src="<?=WEBDIR?>img/menu/<?php if(empty($_GET)) echo 'blanc'; else echo 'gris';?>/icon_menu-07.png" style="position: absolute;left: 10px;width: 20px"/>mes contacts</li></a>
                            <a href='<?=WEBDIR?>inbox'><li style=''><img src="<?=WEBDIR?>img/menu/<?php if(empty($_GET)) echo 'blanc'; else echo 'gris';?>/icon_menu-01.png" style="position: absolute;left: 10px;width: 20px"/>messagerie</li></a>
                            <a href='<?=WEBDIR?>settings'><li style=''><img src="<?=WEBDIR?>img/menu/<?php if(empty($_GET)) echo 'blanc'; else echo 'gris';?>/icon_menu-03.png" style="position: absolute;left: 10px;width: 20px"/>paramètres</li></a>
                            <a href='<?=WEBDIR?>logout'><li style='height: 21px;'><img src="<?=WEBDIR?>img/menu/<?php if(empty($_GET)) echo 'blanc'; else echo 'gris';?>/icon_menu-04.png" style="position: absolute;left: 10px;width: 20px"/>déconnexion</li></a>
                        </ul>
                    </div>
                </div>
            </div>

        <?php
        }
        else
        {
        ?>
        <div class="cell sociaux">
            <ul style="width: 117px;">
                <li class="xs-hidden tel-hidden"><a href="https://www.facebook.com/pages/Mutum/279346655546671"><img src="<?=WEBDIR?>img/picto/fb.png" style="width: 22px" alt=""/></a></li>
                <li class="xs-hidden tel-hidden"><a href="https://twitter.com/mutum_fr"><img src="<?=WEBDIR?>img/picto/twitter.png" style="width: 22px" alt=""/></a></li>
                <li class="xs-hidden tel-hidden"><a href="http://instagram.com/mutum_fr"><img src="<?=WEBDIR?>img/picto/instagram.png" style="width: 22px" alt=""/></a></li>
                <li class="xs-hidden tel-hidden"><a href="https://fr.pinterest.com/mutum_fr"><img src="<?=WEBDIR?>img/picto/pinterest.png" style="width: 22px" alt=""/></a></li>
            </ul>
        </div>
        <div class='cell bouton_header tel-hidden'>
            <a href="<?=WEBDIR?>help/howitworks"><button type='button' class='btn header howto slim <?php if(empty($_GET)) echo "accueil"?>'>comment ça marche ?</button></a>
        </div>
        <div class='cell bouton_header xs-hidden tel-hidden'>
            <a href="<?=WEBDIR?>register"><button type='button' class='btn header long slim <?php if(empty($_GET)) echo "accueil"?>'>m'inscrire</button></a>
        </div>
        <div class='cell bouton_header xs-hidden tel-hidden' id='detect_menu_login' style='position:relative;'>
            <button type='button' id='btnlogin' class='btn header medium login <?php if(empty($_GET)) echo "accueil"?>'>
                <div style='float:left;position: absolute;'>
                    <img src='<?=WEBDIR?>img/login_lock.png' id='login_lock_img' style='margin-top:1px;margin-right:7px;'>
                </div>
                <div style='float:left;margin-top:4px;padding-left: 22px;'>
                    me connecter
                </div>
            </button>

            <div class='menu_login' id='menu_login'>
                <div class='trans'></div>
                <div class='menu_content <?php if(empty($_GET)) echo "accueil"?>'>
                    <form action='<?=WEBDIR?>' method='POST'>
                        <a href='<?=$FacebookLoginUrl?>'>
                            <button type='button' class='btn fbconnect'>
                                <div class='fb_img'>
                                    <img src='<?=WEBDIR?>img/fb_connect.png' style='width:100%;'>
                                </div>
                                <div class='fb_info'>
                                    connexion avec Facebook
                                </div>
                            </button>
                        </a>

                        <div class='or'>
                            ou
                        </div>

                        <div style='position:relative;'>
                            <img src='<?=WEBDIR?>img/login_email.png' style='position:absolute;top:18px;left:10px;'>
                            <input type='text' class='email' name='login' placeholder='Votre email'>
                        </div>

                        <div style='position:relative;'>
                            <img src='<?=WEBDIR?>img/login_password.png' style='position:absolute;top:16px;left:11px;'>
                            <input type='password' class='password' name='password' placeholder='Votre mot de passe'>
                        </div>

                        <div class='reminder'>
                            <a href="<?=WEBDIR?>reminder/forget"><span id='btnreminder'>mot de passe oublié ?</span></a>
                        </div>

                        <div class='keep'>
                            <input type='checkbox' value='1' name='keep' id='keep'>
                            <label for='keep' class='box'></label>
                            <label for='keep' style='padding-left:35px;font-size:15px;cursor:pointer;'>se souvenir de moi</label>
                        </div>

                        <button type='submit' class='btn blue <?php if(empty($_GET)) echo 'accueil' ?> verylong' style='margin-top:10px;margin-bottom:10px;'>se connecter</button>
                    </form>
                </div>
            </div>

        </div>

        <div class='cell' style='width:160px;'>
            <!--
            <div style='float:left;'>
              <button type='button' id='btnfb' class='btn header long slim facebook' style='padding-left:15px;background-color:#ECEDF1;'>
                <div style='float:left;'>
                  <img src='<?=WEBDIR?>img/facebook.png' style='margin-top:-2px;margin-right:7px;'>
                </div>
                <div style='float:left;margin-top:0px;'>
                  j'aime
                </div>
              </button>
            </div>
            <div style='float:left;'>
              <img src='<?=WEBDIR?>img/nb_fb.png' style='margin-top:8px;margin-left:4px;'>
            </div>
					-->
            <div style='position:absolute;margin-top:10px' class="fb-like tel-hidden xs-hidden" data-href="https://www.facebook.com/pages/Mutum/279346655546671?fref=ts" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
        <div class=" tel-hidden xs-hidde" id="fb-root"></div>

        <script>


            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&appId=886305161409231&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

    </div>

    <?php
    }
    ?>

</div>
</div>
</div>


<div class='cover'>
    <?php
    if(empty($_GET['page']))
    {
        echo "<div class='col-sm-18' style='padding:0; margin-top: -25px;'>

                    <img class='tel-hidden sm-hidden xs-hidden' src='".WEBDIR."img/banHome/banLarge_1100.png' style='width:100%;margin-top: -100px;'>
                    <img class='tel-hidden md-hidden xs-hidden' src='".WEBDIR."img/banHome/BanMP_768px.png' style='width:100%;margin-top: 20px;'>
                     <img class='tel-hidden md-hidden sm-hidden' src='".WEBDIR."img/banHome/BanMP_480.png' style='width:100%;margin-top: 20px;'>
                     <img class='xs-hidden md-hidden sm-hidden' src='".WEBDIR."img/banHome/BanMobile.png' style='width:100%;margin-top: 20px;'>

              </div>
              <div style='clear:both;'></div>";
    }

    list($s_a_cat,$s_a_name,$s_a_loc) = article::getArticleSearch();
    ?>
    <div class='search_bar col-md-18' style="padding:0;">
        <div class='input col-md-18'>
            <form method='GET' id='art_search' action='<?=WEBDIR?>search'>
                <div class='s_a_name'>
                    <span class="tel-hidden">quoi ?</span> <input class='s_a_name' id='s_a_name' name='s_a_name' placeholder='quoi ?' value='<?=$s_a_name?>'>
                </div>
                <!--
                <div class='s_a_cat'>
                    catégorie <input class='s_a_cat' id='s_a_cat' name='s_a_cat' placeholder='Categorie' value='<?=$s_a_cat?>'>
                    <div id='s_a_cat_suggest' class='s_a_cat_suggest'></div>
                </div>
                -->
                <div class='s_a_loc'>
                    <span class="tel-hidden">où ?</span> <input class='s_a_loc' id='s_a_loc' name='s_a_loc' placeholder='où ?' value='<?=$s_a_loc?>'>
                    <div id="findme">
                        <img src='<?=WEBDIR?>img/localisation.png' style='' class="cursor">
                    </div>
                </div>
                <div class='s_a_submit'>
                    <input type='hidden' name='a_s' value='<?=time()?>'>
                    <img id='s_a_submit' src='<?=WEBDIR?>img/search_submit.svg' class='s_a_submit'>
                </div>
            </form>
        </div>
        <div class="categories col-md-18 tel-hidden xs-hidden">
            <div class="col-md-2 col-xs-2 col-sm-2 cat" style="padding: 0; ">
                <ul>
                    <li>
                        <a href="/search?s_a_cat=maison&s_a_name=&s_a_loc=" id="maison_cat">maison</a>
                        <ul class="dropdown">
                            <li><a href="/search?s_a_cat=cuisine (appareils et ustensiles)&s_a_name=&s_a_loc=">cuisine (appareils et ustensiles)</a></li>
                            <li><a href="/search?s_a_cat=déco (fêtes...)&s_a_name=&s_a_loc=">déco (fêtes...)</a></li>
                            <li><a href="/search?s_a_cat=entretien / nettoyage&s_a_name=&s_a_loc=">entretien / nettoyage</a></li>
                            <li><a href="/search?s_a_cat=mobilier intérieur/extérieur&s_a_name=&s_a_loc=">mobilier intérieur/extérieur</a></li>
                            <li><a href="/search?s_a_cat=électroménager&s_a_name=&s_a_loc=">électroménager</a></li>
                            <li><a href="/search?s_a_cat=animalerie&s_a_name=&s_a_loc=">animalerie</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-xs-2 col-sm-2 cat" style="padding: 0;">
                <ul>
                    <li>
                        <a href="/search?s_a_cat=brico / jardin&s_a_name=&s_a_loc=" id="brico_cat">brico / jardin</a>
                        <ul class="dropdown">
                            <li><a href="/search?s_a_cat=outils de réparation / bricolage&s_a_name=&s_a_loc=">outils de réparation / bricolage</a></li>
                            <li><a href="/search?s_a_cat=outils de jardinage&s_a_name=&s_a_loc=">outils de jardinage</a></li>
                            <li><a href="/search?s_a_cat=matériel de construction&s_a_name=&s_a_loc=">matériel de construction</a></li>
                            <li><a href="/search?s_a_cat=matériel de rénovation&s_a_name=&s_a_loc=">matériel de rénovation</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-md-2  col-xs-2 col-sm-2 cat" style="padding: 0;">
                <ul>
                    <li>
                        <a href="/search?s_a_cat=culturel&s_a_name=&s_a_loc=" id="culturel_cat">culturel</a>
                        <ul class="dropdown">
                            <li><a href="/search?s_a_cat=art&s_a_name=&s_a_loc=">art</a></li>
                            <li><a href="/search?s_a_cat=livres (jeunesse, BD, romans, cuisine...)&s_a_name=&s_a_loc=">livres (jeunesse, BD, romans, cuisine...)</a></li>
                            <li><a href="/search?s_a_cat=CD&s_a_name=&s_a_loc=">CD</a></li>
                            <li><a href="/search?s_a_cat=DVD&s_a_name=&s_a_loc=">DVD</a></li>
                            <li><a href="/search?s_a_cat=instruments de musique&s_a_name=&s_a_loc=">instruments de musique</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-md-2  col-xs-2 col-sm-2 cat" style="padding: 0;">
                <ul>
                    <li>
                        <a href="/search?s_a_cat=jeux / jouets&s_a_name=&s_a_loc=" id="jeux_cat">jeux / jouets</a>
                        <ul class="dropdown">
                            <li><a href="/search?s_a_cat=jeux de société&s_a_name=&s_a_loc=">jeux de société</a></li>
                            <li><a href="/search?s_a_cat=jeux vidéo et consoles&s_a_name=&s_a_loc=">jeux vidéo et consoles</a></li>
                            <li><a href="/search?s_a_cat=jeux / jouets pour enfants&s_a_name=&s_a_loc=">jeux / jouets pour enfants</a></li>
                            <li><a href="/search?s_a_cat=jeux d extérieur&s_a_name=&s_a_loc=">jeux d'extérieur</a></li>
                            <li><a href="/search?s_a_cat=autres jeux&s_a_name=&s_a_loc=">autres jeux</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-xs-2 col-sm-2 cat" style="padding: 0;">
                <ul>
                    <li>
                        <a href="/search?s_a_cat=high tech&s_a_name=&s_a_loc=" id="tech_cat">high-tech</a>
                        <ul class="dropdown">
                            <li><a href="/search?s_a_cat=matériel de son&s_a_name=&s_a_loc=">matériel de son</a></li>
                            <li><a href="/search?s_a_cat=appareils photo / vidéo&s_a_name=&s_a_loc=">appareils photo / vidéo</a></li>
                            <li><a href="/search?s_a_cat=TV / vidéo-projecteurs&s_a_name=&s_a_loc=">TV / vidéo-projecteurs</a></li>
                            <li><a href="/search?s_a_cat=informatique (tablettes, ordinateurs...)&s_a_name=&s_a_loc=">informatique (tablettes, ordinateurs...)</a></li>
                            <li><a href="/search?s_a_cat=accessoires&s_a_name=&s_a_loc=">accessoires</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-xs-2 col-sm-2 cat" style="padding: 0;">
                <ul>
                    <li>
                        <a href="/search?s_a_cat=sports / activités extérieures&s_a_name=&s_a_loc=" id="sport_cat">sports / loisirs</a>
                        <ul class="dropdown" style="width: 358px;">
                            <li style="width: 317px;"><a href="/search?s_a_cat=sports individuels (athlétisme, tennis, gym…)&s_a_name=&s_a_loc=">sports individuels (athlétisme, tennis, gym…)</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=sports collectifs (football, rugby, volley…)&s_a_name=&s_a_loc=">sports collectifs (football, rugby, volley…)</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=sports d hiver (ski, patinage…)&s_a_name=&s_a_loc=">sports d'hiver (ski, patinage…)</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=sports nautiques (voile, jet ski, kitesurf…)&s_a_name=&s_a_loc=">sports nautiques (voile, jet ski, kitesurf…)</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=sports extrêmes (motocross, dirt, basejump...)&s_a_name=&s_a_loc=">sports extrêmes (motocross, dirt, basejump...)</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=autres sports / activités extérieures&s_a_name=&s_a_loc=">autres sports / activités extérieures</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=matériel de voyage (bagages, sacs à dos…)&s_a_name=&s_a_loc=">matériel de voyage (bagages, sacs à dos…)</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=matériel de camping (tentes...)&s_a_name=&s_a_loc=">matériel de camping (tentes...)</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-xs-2 col-sm-2 cat" style="padding: 0;">
                <ul>
                    <li>
                        <a href="/search?s_a_cat=vêtements / soin&s_a_name=&s_a_loc=" id="soin_cat">vêtements / soin</a>
                        <ul class="dropdown">
                            <li><a href="/search?s_a_cat=vêtements / chaussures&s_a_name=&s_a_loc=">vêtements / chaussures</a></li>
                            <li><a href="/search?s_a_cat=accessoires&s_a_name=&s_a_loc=">accessoires</a></li>
                            <li><a href="/search?s_a_cat=matériel de couture&s_a_name=&s_a_loc=">matériel de couture</a></li>
                            <li><a href="/search?s_a_cat=costumes&s_a_name=&s_a_loc=">costumes</a></li>
                            <li><a href="/search?s_a_cat=soin adulte/enfant/bébé&s_a_name=&s_a_loc=">soin adulte/enfant/bébé</a>
                            <li><a href="/search?s_a_cat=santé&s_a_name=&s_a_loc=">santé</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 col-xs-2 col-sm-2 cat" style="padding: 0;">
                <ul>
                    <li>
                        <a href="/search?s_a_cat=divers&s_a_name=&s_a_loc=">divers</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2  col-xs-2 col-sm-2 cat" style="padding: 0;text-align: center;border: none;">
                <ul>
                    <li>
                        <a href="/search?s_a_cat=transport&s_a_name=&s_a_loc=" style="font-family: bariolRegular;color:#ffffff;font-size: 16px;">transport</a>
                        <ul class="dropdown" style="left: -119px;;">
                            <li><a href="/search?s_a_cat=véhicules&s_a_name=&s_a_loc=">véhicules</a></li>
                            <li><a href="/search?s_a_cat=accessoires&s_a_name=&s_a_loc=">accessoires</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function(){


        // Auto Complétion des addresse de la barre de recherche
        function initialize_menu() {
            var options_auto = { types: ['address'] };
            var input = document.getElementById('s_a_loc');
            var autocomplete = new google.maps.places.Autocomplete(input,options_auto);
        }
        google.maps.event.addDomListener(window, 'load', initialize_menu);

        function showPosition(position) {
            $.post("/js/ajax/localisation.php" ,{ localisation:position.coords.latitude+','+position.coords.longitude } ,function(data){
                $('#s_a_loc').val(data);
                $.cookie('my_location',data,{ expires: 365 , path:'/'});
            });
        }
        function FindMe(){
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Ce navigateur ne supporte pas la géolocalisation");
            }
        }
        $('#findme').click(FindMe);
        if($('#s_a_loc').attr('value')=='')
            FindMe();

        var xhr=false;
        var last_value='';

        function complete_art_category(){
            if(($(this).val()!='' && $(this).val()!=last_value))
            {
                last_value=$(this).val();
                if(xhr!=false)
                {
                    xhr.abort();
                    $('#s_a_cat_suggest').hide();
                }
                xhr = $.post("<?=AJAXLOAD?>retrieve_category" ,{ cat:$(this).val() } ,function(data){
                    if(data!='\n')
                    {
                        $('#s_a_cat_suggest').show();
                        $('#s_a_cat_suggest').html(data);
                    }
                    else
                    {
                        $('#s_a_cat_suggest').hide();
                    }
                });
            }
        }

        $('#s_a_cat').focus(complete_art_category);
        $('#s_a_cat').blur(complete_art_category);
        $('#s_a_cat').keyup(complete_art_category);

        $(document).on('click',function(){
            $('#s_a_cat_suggest').hide();
        });

        $(document).on('click','div.returnCat',function(){
            $('#s_a_cat').val($(this).text());
            $('#s_a_cat_suggest').hide();
            return false;
        });

        $('#s_a_cat').on('click',function(){
            return false;
        });

        $("#s_a_submit").on('click',function(){
            $('#art_search').submit();
        });

        $("#s_a_name").on('keypress',function(e){
            if(e.which == 13) {
                $('#art_search').submit();
            }
        });

        $("#s_a_cat").on('keypress',function(e){
            if(e.which == 13) {
                $('#art_search').submit();
            }
        });

        $("#s_a_loc").on('keypress',function(e){
            if(e.which == 13) {
                $('#art_search').submit();
            }
        });


    });

</script>