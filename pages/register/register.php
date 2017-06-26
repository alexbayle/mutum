<?php

use Facebook\FacebookRequest;
use Facebook\GraphUser;

if(@$_SESSION['fb_action']=='link')
{
  echo "Lier avec: <img src='".$_SESSION['fb_profile_picture']."' >";
  echo $_SESSION['fb_name'];
}
?>

<div class="row2">
    <div class="col-md-18 title">
        <h1>devenir mutum</h1>
    </div>
    <div class="col-md-18 preter">
        <h2>création d'un nouveau compte.</h2>
        <form action="" method='POST'>
            <div class="col-md-9">
                <div class="demande_item">
                    <label for="prenom">prénom<span class="red">*</span> :</label>
                    <input type='text' name='register_firstname' id="prenom" value='<?php echo $user->user_firstname ?>'>
                </div>
                <div class="demande_item">
                    <label for="nom">nom<span class="red">*</span> :</label>
                    <input type='text' name='register_lastname' id="nom" value='<?php echo $user->user_lastname?>'>
                </div>
                <div class="demande_item">
                    <label for="regsiter_birthdate">date de naissance<span class="red">*</span> :</label>
                    <input type='text' name='register_birthdate' id='register_birthdate' value='<?php if ($user->user_birthdate instanceof \DateTime) { echo $user->user_birthdate->format('Y/m/d'); } ?>'>
                </div>
                <div class="demande_item">
                    <label for="genre" style="float: left;">sexe<span class="red">*</span> :</label>
                    <!--<button type="button" class="btn_feminin">féminin</button>-->
                    <input type="radio" name="register_sex" id="radio_f" value="F" style="left: 162px; top: 131px;"/>
                    <div class="col-md-4 feminin" id="fem">
                        <label for="radio_f" style="padding-left: 15px;padding-top: 4px;width: 90px;cursor: pointer;height: 25px;position: absolute;">féminin</label>
                    </div>
                    <span class="col-md-2" style="margin-left: 4px;position: absolute;margin-top: 5px;">ou</span>
                    <!--<button type="button" class="btn_masculin">masculin</button>-->
                    <input type="radio" name="register_sex" id="radio_m" value="M"  style="top: 132px;  left: 305px;"/>
                    <div class="col-md-4 masculin" id="masc">
                        <label for="radio_m" style="padding-left: 15px;padding-top: 4px;width: 90px;cursor: pointer;height: 25px;position: absolute;">masculin</label>
                    </div>
                </div>
                <div class="demande_item" style="margin-top: 60px;">
                    <label for="adress">adresse postale<span class="minisize">(1)</span><span class="red">*</span> :</label>
                    <input type="text" class="myAddress" id="myAddress" name="myAddress" placeholder="adresse..." value="<?= @$addr ?>"/>
                    <div id="findMe">
                        <img src='<?=WEBDIR?>img/localisation.png' style='cursor:pointer;position:absolute;top: 172px;right: 27px;'>
                    </div>
                </div>
                <div class="col-md-18" style="margin-top:18%;">
                    <div class="col-md-1" style="padding: 0;">
                        <input type="checkbox" name="check_cgu" id="check_cgu" style="display: block;width: 20px;"/>
                    </div>
                    <div class="col-md-17" style="padding: 0;">
                        <p style="width: 600px; margin-top: 2px;">
                            En vous inscrivant sur ce site, vous acceptez les <a href="<?=WEBDIR?>legal/cgu">conditions générales d'utilisation</a>.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="demande_item">
                    <label for="email">adresse email<span class="red">*</span> :</label>
                    <input type='email' name='register_email' id="email" value='<?php echo $user->user_email ?>'><br />
                </div>
                <div class="demande_item">
                    <label for="mdp">mot de passe<span class="red">*</span> :</label>
                    <input type='password' name='register_password1' id="mdp" value=''>
                </div>
                <div class="demande_item">
                    <label for="mdp1">confirmer le mot de passe<span class="red">*</span> :</label>
                    <input type='password' name='register_password2' id="mdp1" value=''><br />
                </div>
                <div class="demande_item">
                    <label for="tel">téléphone<span class="minisize">(2)</span> :</label>
                    <input type='text' name='register_phone' id="tel" value='<?php echo $user->user_phone ?>'><br />
                </div>
                <div class="demande_item">
                    <label for="codeparrain">code parrain :</label>
                    <span class="mutum_10">+10 mutum</span>
                    <input type='text' name='register_godfather' id="codeparrain" value='<?php echo $user->user_godfather ?>'><br />
                </div>
                <div class="demande_item">
                    <label for="codepromo">code promo :</label>
                    <input type="text" name="register_codepromo" id="codepromo"/>
                </div>
                <div class="send3">
                    <input id="suiteForm" type='' name='' value='suite' style="text-align: center">
                    <!--<input id="suiteForm1" type='' name='' value='suite' style="text-align: center">-->
                </div>
            </div>


            <!--  POP - IN AVATAR -->

            <div class="col-md-18 preter pop-in">
                <div class="title"><h1 style="color: #515151;">choisissez votre avatar</h1></div>
                <div>
                    <img id="avatar_1" class="avatar" src="<?=WEBDIR?>img/personnageRangs/niv_1/1.png" style="width: 18%;margin-left: 4%;"/>
                    <img id="avatar_2" class="avatar" src="<?=WEBDIR?>img/personnageRangs/niv_1/2.png" style="width: 18%;opacity: 0.2"/>
                    <img id="avatar_3" class="avatar" src="<?=WEBDIR?>img/personnageRangs/niv_1/3.png" style="width: 18%;opacity: 0.2"/>
                    <img id="avatar_4" class="avatar" src="<?=WEBDIR?>img/personnageRangs/niv_1/4.png" style="width: 18%;opacity: 0.2"/>
                    <img id="avatar_5" class="avatar" src="<?=WEBDIR?>img/personnageRangs/niv_1/5.png" style="width: 18%;opacity: 0.2"/>
                </div>
                <input type="hidden" class="inputAvatar" name="avatar" value="1"/>

                <div class="send3 col-md-offset-3 col-md-8">
                    <input type='submit' name='btnregister' value='confirmation'>
                </div>
            </div>
            <div class="trucGris" style="width: 100%;height: 100%;top:0;left: 0"></div>


        </form>
    </div>

    <!--<div class="col-md-9 preter" id="addcom" style="height: auto;display: none;">
        <h2>rejoindre une/des communautés.</h2>

        <div class="demande_item">
            <p>séléctionner le nombre de communautés que vous voulez rejoindre :</p>
            <br />
            <select name="selectcom" id="selectcom" style="left:2%;height: 24px;width:216px;">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            <br />
        </div>


        <div class="demande_item" id="join_1">
            <?php if(community::getAllCommunity() != array()){ ?>
                <select id="communities_1" name="communitie" style="left:5%;height: 24px;width:216px;">
                    <?php foreach (community::getAllCommunity() as $community) : ?>
                        <option value="<?php echo $community[0]->getAttr('id') ?>"><?php echo $community[0]->getAttr('name') ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="email" class="" name="emailcom_1" id="emailcom_1" placeholder="adresse email..." style="width: 216px;"/>
            <?php }else{ ?>
            <?php }?>
        </div>

        <div class="demande_item" id="join_2" style="display: none;margin-top: 60px;">
            <?php if(community::getAllCommunity() != array()){ ?>
                <select id="communities_2" name="communitie_2" style="left:5%;height: 24px;width:216px;">
                    <?php foreach (community::getAllCommunity() as $community) : ?>
                        <option value="<?php echo $community[0]->getAttr('id') ?>"><?php echo $community[0]->getAttr('name') ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="email" class="" name="emailcom_2" id="emailcom_2" placeholder="adresse email..." style="width: 216px;"/>
            <?php }else{ ?>
            <?php }?>
        </div>

        <div class="demande_item" id="join_3" style="display: none;margin-top: 100px;">
            <?php if(community::getAllCommunity() != array()){ ?>
                <select id="communities_3" name="communitie_3" style="left:5%;height: 24px;width:216px;">
                    <?php foreach (community::getAllCommunity() as $community) : ?>
                        <option value="<?php echo $community[0]->getAttr('id') ?>"><?php echo $community[0]->getAttr('name') ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="email" class="" name="emailcom_3" id="emailcom_3" placeholder="adresse email..." style="width: 216px;"/>
            <?php }else{ ?>
            <?php }?>
        </div>

        <div class="demande_item" id="join_4" style="display: none;margin-top: 140px;">
            <?php if(community::getAllCommunity() != array()){ ?>
                <select id="communities_4" name="communitie_4" style="left:5%;height: 24px;width:216px;">
                    <?php foreach (community::getAllCommunity() as $community) : ?>
                        <option value="<?php echo $community[0]->getAttr('id') ?>"><?php echo $community[0]->getAttr('name') ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="email" class="" name="emailcom_4" id="emailcom_4" placeholder="adresse email..." style="width: 216px;"/>
            <?php }else{ ?>
            <?php }?>
        </div>

        <div class="send3 col-md-18" style="margin-top: 60px;">
            <input id="suiteForm" type='' name='' value='suite' style="text-align: center">
        </div>
    </div>

    <div class="col-md-18 infos_register">
        <p>
            champs obligatoires <br />
            (1) l'adresse ne sert qu'à trouver les objets les plus proches de chez vous, elle n'est pas communiquée ni marquée sur le site <br />
            (2) ne sera visible par votre correspondant que si vous  lui envoyez un message. Vous pouvez cependant chosir de cacher votre numéro dans vos paramètre.
        </p>
    </div>-->
</div>



<script type="text/javascript">
    $(document).ready(function(){

        $('#suiteForm').click(function(){
            $('.pop-in').fadeIn();
            $('.trucGris').fadeIn();
        });

        $('#suiteForm1').click(function(){
            $('#addcom').slideToggle();
            $('#addcom').scrollTop();
        });

        $('.avatar').click(function(){
            var avatarNb = $(this).attr('id').replace('avatar_','');
            $('.inputAvatar').val(avatarNb);
            $('.avatar').css('opacity','0.2');
            $(this).css('opacity','1');
        });

        $(function() {
            $("#selectcom").change(function() {
                var nb = $(this).val();

                if(nb == 2){
                    $('#join_2').css('display','block');
                    $('#join_3').css('display','none');
                    $('#join_4').css('display','none');
                }else if(nb == 3){
                    $('#join_2').css('display','block');
                    $('#join_3').css('display','block');
                    $('#join_4').css('display','none');
                }else if(nb == 4){
                    $('#join_2').css('display','block');
                    $('#join_3').css('display','block');
                    $('#join_4').css('display','block');
                }else{
                    $('#join_2').css('display','none');
                    $('#join_3').css('display','none');
                    $('#join_4').css('display','none');
                }
            });
        });



        // Auto Complétion des addresse de la barre de recherche
        function initialize_menu() {
            var options_auto = { types: ['address'] };
            var input = document.getElementById('myAddress');
            var autocomplete = new google.maps.places.Autocomplete(input,options_auto);
        }
        google.maps.event.addDomListener(window, 'load', initialize_menu);


    function showPosition(position) {
        $.post("/js/ajax/localisation.php" ,{ localisation:position.coords.latitude+','+position.coords.longitude } ,function(data){
            $('#addr').val(data);
            $('#myAddress').val(data);
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

    $('#findMe').click(FindMe);


        $('.feminin').click(function(){

            if($('#masc').hasClass('masculin2'))
            {
                $('#masc').removeClass('masculin2');
                $(this).addClass('feminin2');
            }
            else if($(this).hasClass('feminin2'))
            {
                $(this).removeClass('feminin2');
            }
            else{
                $(this).addClass('feminin2');
            }

        });

        $('.masculin').click(function(){
            if($('#fem').hasClass('feminin2'))
            {
                $('#fem').removeClass('feminin2');
                $(this).addClass('masculin2');
            }
            else if($(this).hasClass('masculin2'))
            {
                $(this).removeClass('masculin2');
            }
            else{
                $(this).addClass('masculin2');
            }

        });

        $('#register_birthdate').datetimepicker({
            timepicker:false,
            formatDate:'Y/m/d',
            lang:'fr',
            format:'Y/m/d'
        });

    });
</script>
