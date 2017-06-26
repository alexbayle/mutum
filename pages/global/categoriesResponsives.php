<style>


    .dropdownResponsive{
        display: none;
    }

    .menu_avatar img{
        border-radius: 4000px;
        width: 40%;
    }

    .dropdownResponsiveCat{
        display: none;
    }

    .responsiveUser{
        font-size: 20px;
        padding: 2px;
    }

    .responsiveUser a li {
        border-top: 1px solid #42cdd9;
        margin: 0;
        padding: 8px;
    }

    input.responsive{
        box-shadow: none;
        padding: 5px 5px 5px 5px;
        color: #AAAAAA;
        border: 2px solid #D9D9D9;
        font-size: 12px;
        width: 70%;
        height: 30px;
        margin: 5%;
        padding-left: 30px;
    }


</style>


<div class="categoriesResponsives">
    <?php
    if(Session::Online())
    {
    ?>
    <ul style="background-color: #01B8C8;">
        <li>
        <div class='cell noborder userMoney' style="  width: 74px;position: absolute;top: 85px;left: 50%;">
            <a href='<?=WEBDIR?>success/wallet'>
                <div class='credit_info' style="display: inline-block">
                    <?=Session::Me()->getAttr('credit');?>
                </div>
                <div class='credit_img' style="display: inline-block">
                    <img src='<?=WEBDIR?>img/header_number_mutum.png' style='width:17px;height: 17px'>
                </div>
            </a>
        </div>


        <div class='cell catRes' style='position:relative;' style="display: inline-block">
            <div class='menu_name' style="position: absolute;left: 50%;">
                <?php $nom = Session::Me()->getAttr('lastname');?>
                <?=Session::Me()->getAttr('firstname');?>
                <?= strtoupper($nom[0]); ?>
            </div>
            <div class='menu_img' style="display: inline-block;">
                <div class="menu_avatar">
                    <?php echo Session::Me()->print_user('40%') ?>
                </div>
                <div class='menu_arrow'>
                </div>
                <div class='notification' style="display: none;">
                    1
                </div>
            </div>
            <a href='<?=WEBDIR?>success/list' style="display: inline-block">
                <div class='progress_info' style="position: absolute;top: 35px;left: 50%;">
                    <div class='progress_number'><?php echo count(achievements::getMyOwnAchievementsByCat(\Session::Me()->user_id)) ?>/<?php echo achievements::countAchievementsByCat() ?> succès</div>
                    <div class="successAccueil">
                        <progress  value="<?php echo count(achievements::getMyOwnAchievementsByCat(\Session::Me()->user_id)); ?>" max="<?php echo achievements::countAchievementsByCat() ?>" form="form-id"></progress>
                    </div>
                </div>
            </a>

            <div>
                    <ul class='dropdownResponsive responsiveUser'>
                        <a href='<?=WEBDIR?>profile'><li style="margin-top: 10px;  border-top: none;"><img src="<?=WEBDIR?>img/menu/blanc/icon_menu-05.png" style="margin-right: 10px;width: 20px;"/>mon compte</li></a>
                        <a href='<?=WEBDIR?>items'><li class=''><img src="<?=WEBDIR?>img/menu/blanc/icon_menu-09.png" style="margin-right: 10px;width: 20px"/>mes objets</li></a>
                        <a href='<?=WEBDIR?>loan'><li class=''><img src="<?=WEBDIR?>img/menu/blanc/icon_menu-08.png" style="margin-right: 10px;width: 20px"/>mes prêts / emprunts</li></a>
                        <a href='<?=WEBDIR?>community'><li class=''><img src="<?=WEBDIR?>img/menu/blanc/icon_menu-06.png" style="margin-right: 10px;width: 20px"/>mes communautés</li></a>
                        <a href='<?=WEBDIR?>wishlist'><li class=''><img src="<?=WEBDIR?>img/menu/blanc/icon_menu-02.png" style="margin-right: 10px;width: 20px"/>liste de souhaits</li></a>
                        <a href='<?=WEBDIR?>contact'><li class=''><img src="<?=WEBDIR?>img/menu/blanc/icon_menu-07.png" style="margin-right: 10px;width: 20px"/>mes contacts</li></a>
                        <a href='<?=WEBDIR?>inbox'><li class=''><img src="<?=WEBDIR?>img/menu/blanc/icon_menu-01.png" style="margin-right: 10px;width: 20px"/>messagerie</li></a>
                        <a href='<?=WEBDIR?>settings'><li class=''><img src="<?=WEBDIR?>img/menu/blanc/icon_menu-03.png" style="margin-right: 10px;width: 20px"/>paramètres</li></a>
                        <a href='<?=WEBDIR?>logout'><li class=''><img src="<?=WEBDIR?>img/menu/blanc/icon_menu-04.png" style="margin-right: 10px;width: 20px"/>déconnexion</li></a>
                    </ul>
            </div>

        </div>
        </li>
    </ul>
    <?php } else { ?>
        <ul style="background-color: #01B8C8;">
            <li>
                <div class=''>
                    <p style="padding: 5px 10px;  border-bottom: 1px solid #42cdd9;  font-size: 28px;background-color: #00A2B0;"><a href="<?=WEBDIR?>register">M'inscrire</a></p>
                </div>
                <div class=''>
                    <p style="padding: 5px 10px;  border-bottom: 1px solid #42cdd9;  font-size: 28px;background-color: #00A2B0;"><a href="<?=WEBDIR?>register"><img src='<?=WEBDIR?>img/login_lock.png' id='login_lock_img' style='margin-top:1px;margin-right:7px;'>Me connecter</a></p>
                    <div>
                        <div>
                            <form action='<?=WEBDIR?>' method='POST'>
                                <a href='<?=$FacebookLoginUrl?>'>
                                    <button type='button' class='btn fbconnect' style="width: 80%;padding: 10px;margin-left: 5%;">
                                        <div class='fb_img' style="display: inline">
                                            <img src='<?=WEBDIR?>img/fb_connect.png' style='width: 25px;float: left;margin-left: 5%;'>
                                        </div>
                                        <div class='fb_info'  style="display: inline;font-size: 15px;">
                                            connexion avec Facebook
                                        </div>
                                    </button>
                                </a>

                                <div class='or' style="margin-left: 40%;padding: 5px;font-size: 35px;">
                                    ou
                                </div>

                                <div style='position:relative;'>
                                    <img src='<?=WEBDIR?>img/login_email.png' style='position: absolute;top: 43%;left: 8%;height: 10px;'>
                                    <input type='text' class='email responsive' name='login' placeholder='Votre email'>
                                </div>

                                <div style='position:relative;'>
                                    <img src='<?=WEBDIR?>img/login_password.png' style='position: absolute;top: 43%;left: 8%; height: 10px;'>
                                    <input type='password' class='password responsive' name='password' placeholder='Votre mot de passe'>
                                </div>

                                <div class='reminder' style="margin-left: 30%;">
                                    <a href="<?=WEBDIR?>reminder/forget"><span id='btnreminder'>mot de passe oublié ?</span></a>
                                </div>

                                <button type='submit' class='btn blue verylong' style='width: 80%;margin-left: 5%;height: 60px;font-size: 18px;margin-top:10px;margin-bottom:10px;'>se connecter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

    <?php } ?>
        <p class="catResCat" style="padding: 5px 10px;  border-bottom: 3px solid #42cdd9;  font-size: 25px;background-color: #00A2B0;">catégories
        <ul style="background-color: #00A2B0;">
            <li class="dropdownResponsiveCat">
                <ul class="catRes ">
                    <li>
                        <a href="/search?s_a_cat=maison&s_a_name=&s_a_loc=" id="maison_cat">maison</a>
                        <ul class="dropdownResponsive">
                            <li><a href="/search?s_a_cat=cuisine (appareils et ustensiles)&s_a_name=&s_a_loc=">cuisine (appareils et ustensiles)</a></li>
                            <li><a href="/search?s_a_cat=déco&s_a_name=&s_a_loc=">déco (fêtes...)</a></li>
                            <li><a href="/search?s_a_cat=entretien / Nettoyage&s_a_name=&s_a_loc=">entretien / nettoyage</a></li>
                            <li><a href="/search?s_a_cat=mobilier intérieur et extèrieur&s_a_name=&s_a_loc=">mobilier intérieur/extèrieur</a></li>
                            <li><a href="/search?s_a_cat=electroménager&s_a_name=&s_a_loc=">électroménager</a></li>
                            <li><a href="/search?s_a_cat=jardin / Animalerie&s_a_name=&s_a_loc=">animalerie</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="catRes">
                    <li>
                        <a href="/search?s_a_cat=bricolage / Jardinage&s_a_name=&s_a_loc=" id="brico_cat">brico / jardin</a>
                        <ul class="dropdownResponsive">
                            <li><a href="/search?s_a_cat=outils de réparation / Bricolage&s_a_name=&s_a_loc=">outils de réparation / bricolage</a></li>
                            <li><a href="/search?s_a_cat=outils de jardinage&s_a_name=&s_a_loc=">outils de jardinage</a></li>
                            <li><a href="/search?s_a_cat=matériel de construction&s_a_name=&s_a_loc=">matériel de construction</a></li>
                            <li><a href="/search?s_a_cat=matériel de rénovation&s_a_name=&s_a_loc=">matériel de rénovation</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="catRes">
                    <li>
                        <a href="/search?s_a_cat=culturel&s_a_name=&s_a_loc=" id="culturel_cat">culturel</a>
                        <ul class="dropdownResponsive">
                            <li><a href="/search?s_a_cat=art&s_a_name=&s_a_loc=">art</a></li>
                            <li><a href="/search?s_a_cat=livres (jeunesse, bd, romans, cuisine...)&s_a_name=&s_a_loc=">livres (jeunesse, BD, romans, cuisine...)</a></li>
                            <li><a href="/search?s_a_cat=cd&s_a_name=&s_a_loc=">CD</a></li>
                            <li><a href="/search?s_a_cat=dvd&s_a_name=&s_a_loc=">DVD</a></li>
                            <li><a href="/search?s_a_cat=instruments de musique&s_a_name=&s_a_loc=">instruments de musique</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="catRes">
                    <li>
                        <a href="/search?s_a_cat=jeux / Jouets&s_a_name=&s_a_loc=" id="jeux_cat">jeux / jouets</a>
                        <ul class="dropdownResponsive">
                            <li><a href="/search?s_a_cat=jeux de société&s_a_name=&s_a_loc=">jeux de société</a></li>
                            <li><a href="/search?s_a_cat=jeux vidéo et consoles&s_a_name=&s_a_loc=">jeux vidéo et consoles</a></li>
                            <li><a href="/search?s_a_cat=jeux / Jouets pour enfants&s_a_name=&s_a_loc=">jeux / jouets pour enfants</a></li>
                            <li><a href="/search?s_a_cat=jeux d'exterieur_a_name=&s_a_loc=">jeux d'extérieur</a></li>
                            <li><a href="/search?s_a_cat=autres jeux&s_a_name=&s_a_loc=">autres jeux</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="catRes">
                    <li>
                        <a href="/search?s_a_cat=high tech&s_a_name=&s_a_loc=" id="tech_cat">high-tech</a>
                        <ul class="dropdownResponsive">
                            <li><a href="/search?s_a_cat=matériel de son&s_a_name=&s_a_loc=">matériel de son</a></li>
                            <li><a href="/search?s_a_cat=appareil Photo / Vidéo&s_a_name=&s_a_loc=">appareils photo / vidéo</a></li>
                            <li><a href="/search?s_a_cat=tv / vidéo-projecteur&s_a_name=&s_a_loc=">TV / vidéo-projecteurs</a></li>
                            <li><a href="/search?s_a_cat=informatique (tablettes, ordinateurs...)&s_a_name=&s_a_loc=">informatique (tablettes, ordinateurs...)</a></li>
                            <li><a href="/search?s_a_cat=accessoires High-tech&s_a_name=&s_a_loc=">accessoires</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="catRes">
                    <li>
                        <a href="/search?s_a_cat=sports / activités extérieures&s_a_name=&s_a_loc=" id="sport_cat">sports / loisirs</a>
                        <ul class="dropdownResponsive">
                            <li style="width: 317px;"><a href="/search?s_a_cat=sports individuels (athlétisme, tennis, gym...)&s_a_name=&s_a_loc=">sports individuels (athlétisme, tennis, gym...)</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=sports collectifs (football, rugby, volley...)&s_a_name=&s_a_loc=">sports collectifs (football, rugby, volley...)</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=sports d hiver (ski, patinage...)&s_a_name=&s_a_loc=">sports d'hiver (ski, patinage...)</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=sports nautiques (voile, jet ski, kitesurf...)&s_a_name=&s_a_loc=">sports nautiques (voile, jet ski, kitesurf...)</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=sports extrèmes (motocross, dirt, basejump...)&s_a_name=&s_a_loc=">sports extrèmes (motocross, dirt, basejump...)</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=autres sports / activités extérieures&s_a_name=&s_a_loc=">autres sports / activités extérieures</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=matériel de voyage (bagages, sac à dos...)&s_a_name=&s_a_loc=">matériel de voyage (bagages, sacs à dos...)</a></li>
                            <li style="width: 317px;"><a href="/search?s_a_cat=matériel de camping (tente...)&s_a_name=&s_a_loc=">matériel de camping (tentes...)</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="catRes">
                    <li>
                        <a href="/search?s_a_cat=habillement / soin / santé&s_a_name=&s_a_loc=" id="soin_cat">soin / vêtements</a>
                        <ul class="dropdownResponsive">
                            <li><a href="/search?s_a_cat=vètements / chaussures&s_a_name=&s_a_loc=">vêtements / chaussures</a></li>
                            <li><a href="/search?s_a_cat=accessoires&s_a_name=&s_a_loc=">accessoires</a></li>
                            <li><a href="/search?s_a_cat=matériel de couture&s_a_name=&s_a_loc=">matériel de couture</a></li>
                            <li><a href="/search?s_a_cat=costumes&s_a_name=&s_a_loc=">costumes</a></li>
                            <li><a href="/search?s_a_cat=soin adulte / enfant / bébé&s_a_name=&s_a_loc=">soin adulte/enfant/bébé</a>
                            <li><a href="/search?s_a_cat=santé&s_a_name=&s_a_loc=">santé</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="catRes">
                    <li>
                        <a href="/search?s_a_cat=divers&s_a_name=&s_a_loc=">divers</a>
                    </li>
                </ul>
                <ul class="catRes">
                    <li>
                        <a href="/search?s_a_cat=transport&s_a_name=&s_a_loc=">transport</a>
                        <ul class="dropdownResponsive">
                            <li><a href="/search?s_a_cat=véhicules&s_a_name=&s_a_loc=">véhicules</a></li>
                            <li><a href="/search?s_a_cat=accessoires&s_a_name=&s_a_loc=">accessoires</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>


</div>




<div class="trucGris"></div>
<img src="/img/menu-responsive.png" class="icone_responsive">
<script>
    $('.catRes').click(function(){
        if(!$(this).hasClass('open'))
            $(this).addClass('open').children().children('.dropdownResponsive').slideDown(750);
        else $(this).removeClass('open').children().children('.dropdownResponsive').slideUp(750);
    });

    $('.catResCat').click(function(){
        if(!$(this).hasClass('open')){
            $(this).addClass('open');
            $('.dropdownResponsiveCat').slideDown(750);
        }
        else {
            $(this).removeClass('open');
            $('.dropdownResponsiveCat').slideUp(750);
        }
    });

    $('.trucGris').click(function(){
        $('.trucGris').fadeOut(500);
        $('.categoriesResponsives').animate({left:"-80%"},500);
    });


    $('.icone_responsive').click(function(){
        $('.trucGris').fadeIn(500);
        $('.categoriesResponsives').animate({left:"0%"},500);
    });


</script>