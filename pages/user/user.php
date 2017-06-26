<section id ="load" style="padding:50px; background:red;display:none; position:absolute; z-index:2000">chargement</section>
<?php
$module =  $_GET["module"];
?>
<div class="col-md-18 title">
    <h1><strong>profil de <?= $user->printName() ?></strong></h1>
</div>
<form name ="userActions" action="" method="post" >
<section>

    <div  class="col-md-18 bannerUser" >

        <br/>
        <div class="col-md-18" >
            <section class="col-md-3 col-xs-18">
                <div class="avatar"><?php  echo $user->print_user(140);?></div>
            </section>
            <section class="col-md-12">
                <ul>
                    <li class="userData" >ville : <span class="labelUserInfo"><?php echo user::getCity($user->getAttr('address')); ?></span></li>
                    <?php if(contact::isContact($user->getAttr('id'))){  ?>
                        <li class="userData" >adresse : <span class="labelUserInfo"><?php echo address::getAddressById($user->getAttr('id')); ?></span></li>
                    <?php } ?>
                    <li class="userData" >email : <span class="labelUserInfo"><?php echo $user->getAttr('email'); ?></span></li>
                    <li class="userData">nombre d'objets :  <span class="labelUserInfo"><?= sizeof(user::getUserArticle($user->getAttr('id'))) ?></span></li>
                    <li class="userData">avis prêteurs : <span class="labelUserInfo"><?= sizeof($user->getNotePreteur()) ?></span></li>
                    <li class="userData">avis emprunteurs :  <span class="labelUserInfo"><?= sizeof($user->getNoteEmpreinteur()) ?></span></li>
                    <li class="userData">contacts :  <span class="labelUserInfo"><?= sizeof(contact::seeAllContact()) ?></span></li>
                    <li class="userData">classement : <span class="labelUserInfo"><?php $rank=$user->getScoreRanks(); echo $rank['general']; ?></span></li><!-- Fonction sur le classement a faire !-->
                </ul>
            </section>
            <section class="col-md-3">
                    <?php if(!contact::isContact($user->getAttr('id'))){  ?>
                        <? if(contact::checkExistAsk($module)){?>
                           <button name='btnAdd' class="ajout " value='Ajouter aux contacts'>ajouter</button>
                        <? } ?>
                    <?php }
                    else{ ?>
                           <button id='send' name='sendmsg' class="envoyerMessage" value='Envoyer un message'>message</button>
                        <? if(contact::checkExistContactForDelete($module)){?>
                            <button name='btnSupp' class="suppr " value='Supprimer des contacts'>supprimer</button>
                        <? } ?>
                    <?php } ?>

            </section>

        </div>
    </div>
</section>
    <div class="col-md-18 menu_onglet"style="padding-left: 0;padding-right: 0">
        <ul>
            <li class="onglet_1 actif"><a class="first" href="#" style="left:2% ">consulter ses objets</a></li>
            <li class="onglet_2"><a class="second" href="#" style="left:20%;">avis prêteur</a></li>
            <li class="onglet_3"><a class="third" href="#" style="">avis emprunteur</a></li>
        </ul>
    </div>

</form>
<div class="col-md-18  radiusOnglets preter" style="
-webkit-border-top-right-radius: 10px;
    -webkit-border-bottom-left-radius: 10px;
    -webkit-border-top-left-radius: 0px;
    -moz-border-radius-topright: 10px;
    -moz-border-radius-bottomleft: 10px;
    -moz-border-radius-topleft:0px ;
    border-top-right-radius: 10px;
    border-bottom-left-radius: 10px;
    border-top-left-radius:0px;
      ">
    <!--
    <div id ="sectionWrite" class='col-md-18'>
        <div class='msg'>
            <h1>Envoyer un message</h1>
            <form action="" method="post">
                <div class="row">
                    <label class=" col-md-3" for="exampleInputEmail1">Objet de votre message:</label>
                    <input type="text" class="form-control col-md-6" id="exampleInputObjet" placeholder="Saisissez l'objet de votre mail" name='discName'>
                </div><br><br>
                <textarea class="form-control col-md-9"  name='text' rows="10">Saisissez votre message</textarea><br><br>
                <div class="row">
                    <div class="form-group col-md-18 top-buffer"><button type="submit"  name='btnSend' class="btn btn-lg">Envoyer</button></div>
                </div>
            </form>
        </div>
    </div>
    -->
<!--
    <section id="sectionAdd" class='col-md-18'>
        <h1>Ajouter un contact</h1>
        <!--form action="" method="post" class="col-md-9">
            <div class="form-group col-md-18">

            </div>
            <textarea  class="form-control col-md-18"  name='text'>Saisissez votre message</textarea>
            <button type="submit"  name='btnSend' class="btn btn-lg">Ajouter à mes contacts</button>
            -->
            <!--div id='cancel' style='float:left'>
                <button type="submit" type='submit' name='btnCancelAsk' class="btn btn-lg">annuler votre demande</button>
            </div-->
        <!--/form-->
    <!--
       <form action="" method="post">
           <div class="row">
               <div class="form-group col-md-18 top-buffer">
                   <input type="submit" name='btnAdd' value="envoyer" class="btn btn-lg"/>
               </div>
           </div>
       </form>
   </section>
   -->

    <section  id="sectionObj" class="col-md-18">


        <h1>Les objets de <?= $user->printName(); ?></h1>

        <br/><p>Il y'a <span class="userData blue"><?php echo count(user::getUserArticle($user->getAttr('id')) ); ?></span> objet(s)</p><br/>

        <div class="userProducts col-md-18">

            <?php
/*
            if($nbArticle ==4 || $nbArticle<3){
                $pagination=false;
                include("templates/list.php");
            }


            if($nbArticle==3 || $nbArticle==5){
                include("templates/boxes.php");
            }


            if($nbArticle>5){*/

                include("templates/boxes.php");
                /*echo "<h1>Tous les articles box</h1>";	*/
                include("templates/list.php");
/*
            }*/?>



            <?php if ($pagination==true):?>
                <div class="col-md-18 " >
                    <?php foreach ($pages as $kPage=>$page): ?>
                        <a class="numPage" href="<?php echo $kPage;?>"><?php echo " ".$kPage+1 ." ";?></a>
                    <?php endforeach ?>
                </div>
            <?php endif?>
        </div>

    </section>
    <section id="sectionNote" class="col-md-18" style="display: none">
        <h1>Les avis de <?= $user->printName() ?></h1>
        <?php
        if($user->getNotePreteur()==array()){
            echo '<h2>Aucun avis</h2>';
        }
        foreach ($user->getNotePreteur() as $note) { ?>

        <div class="col-md-18" style="padding: 15px;">


            <div class="col-md-4">
                <p>avis pour <a  style=" text-decoration: none; color: black;" href="<?= WEBDIR.'view/'.$note[0]->nota_prod_id?>"><span style="font-weight: bold"><?= product::getById($note[0]->nota_prod_id)[0][0]->prod_name; ?></span></a></p>
                <p style="font-size: 14px;padding: 3px;">emprunté par <a style=" text-decoration: none;color: #00A2B0; " href="<?=WEBDIR.'user/'.$note[0]->nota_user_id ?>"> <?= user::getById($note[0]->nota_user_id)[0][0]->user_firstname;?></a> </p>
                <p style="font-size: 12px;padding: 3px;">le <?= $note[0]->nota_date_creation;?> </p>
            </div>
            <div class="col-md-3">
                <?php
                    $note_user = $note[0]->nota_note;
                    \user::printNoteUser($note_user);
                ?>
            </div>
            <div class="col-md-10">
                <?= $note[0]->nota_message; ?>
            </div>

            <br/>

        </div>
            <hr/>
        <?php } ?>
    </section>
    <section id="sectionNote2" class="col-md-18" style="display: none">
        <h1>Les avis de <?= $user->printName() ?></h1>
        <?php
        if($user->getNoteEmpreinteur()==array()){
            echo '<h2>Aucun avis</h2><br/>';
        }
        foreach ($user->getNoteEmpreinteur() as $note) {?>

            <div class="col-md-18" style="padding: 15px;">


                <div class="col-md-4">
                    <p>avis pour <a  style=" text-decoration: none; color: black;" href="<?= WEBDIR.'view/'.$note[0]->nota_prod_id?>"><span style="font-weight: bold"><?= product::getById($note[0]->nota_prod_id)[0][0]->prod_name; ?></span></a></p>
                    <p style="font-size: 14px;padding: 3px;">prêté par <a style=" text-decoration: none;color: #00A2B0; " href="<?=WEBDIR.'user/'.$note[0]->nota_user_id ?>"> <?= user::getById($note[0]->nota_user_id)[0][0]->user_firstname;?></a> </p>
                    <p style="font-size: 12px;padding: 3px;">le <?= $note[0]->nota_date_creation;?> </p>
                </div>
                <div class="col-md-3">
                    <?php
                    $note_user = $note[0]->nota_note;
                    \user::printNoteUser($note_user);
                    ?>
                </div>
                <div class="col-md-10">
                    <?= $note[0]->nota_message; ?>
                </div>

                <br/>

            </div>
            <hr/>
        <?php };
        ?>
    </section>
</div>
<script type="text/javascript">

    $(document).ready(function () {





        // ajout d'une id dynamique a chaque input button dans le formulaire
        //var controls = ($("form[name='userActions'] input[type='button']"));


        /*
         * fonction init
         *role: fonction d'initialisation au chargement de la page
         */
        /*
        function init() {
            hideAllUserdatas();
            //console.log(controls[0].attr('name'));
            console.log("activé par default:"+$(controls[0]).attr('name'));
            $("#" + $(controls[0]).attr('name')).show();
            $(controls[0]).css({"background":"#E6E6E6"});

        }*/

        /*
         *hideAllUserdatas
         *role: cache toutes les rubriques d'action utilisateur( ajouter aux contacts,envoyer un message, Consulter les objets,....)
         */
         /*
        function hideAllUserdatas() {
            $(controls).each(function (elmt) {
                var elem = ($(this).attr('name'));
                $("#" + elem).hide();

                $(this).css({
                    "background":"#F0F0F0"
                })
            })
        }*/

        /*gestion de l'evenement click sur une rubrique utilisateur */
        /*
        $("form[name='userActions'] input[type='button']").click(function (e) {
            hideAllUserdatas();
            e.preventDefault();
            var elem = $(this).attr('name');
            $("#" + elem).fadeIn();


            $('html,body').animate({scrollTop: $("#" + elem).offset().top}, 'slow'      );

            $(this).css({
                "background":"#E6E6E6"
            })
        });
        */

        //affichage de la liste d'objets sous forme de catalogue paginé


        $(".pageProducts").hide();
        $(".pageProducts:first").show();

        $(".numPage").each(function(){
            $(this).click(function(e){
                e.preventDefault();

                var indexPageSelected = $(this).attr('href');
                $(".pageProducts").hide();
                $(".pageProducts:eq("+indexPageSelected+")").fadeToggle();
            })
        });

        $('.onglet_1').click(function(e){
            e.preventDefault();
            $('#sectionObj').show();
            $('#sectionNote').hide();
            $('#sectionNote2').hide();
            if(!$('.onglet_1').hasClass('actif')){
                $('.onglet_1').addClass('actif');
                $('.onglet_2').removeClass('actif');
                $('.onglet_3').removeClass('actif');
            }
        });
        $('.onglet_2').click(function(e){
            e.preventDefault();
            $('#sectionObj').hide();
            $('#sectionNote2').hide();
            $('#sectionNote').show();
            if(!$('.onglet_2').hasClass('actif')){
                $('.onglet_2').addClass('actif');
                $('.onglet_1').removeClass('actif');
                $('.onglet_3').removeClass('actif');
            }
        });

        $('.onglet_3').click(function(e){
            e.preventDefault();
            $('#sectionObj').hide();
            $('#sectionNote').hide();
            $('#sectionNote2').show();
            if(!$('.onglet_3').hasClass('actif')){
                $('.onglet_3').addClass('actif');
                $('.onglet_1').removeClass('actif');
                $('.onglet_2').removeClass('actif');
            }
        });




       // init();
    })
</script>