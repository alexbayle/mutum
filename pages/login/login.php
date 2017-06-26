<?php
if(@$_SESSION['fb_action']=='link')
{
  echo "Lier avec: <img src='".$_SESSION['fb_profile_picture']."' >";
  echo $_SESSION['fb_name'];
}
?>
<div class="row2">
    <div class="col-md-18 title">
        <h1>bienvenue !</h1>
    </div>
    <div class="col-md-18 preter">
        <h2>me connecter</h2>
        <form action='<?=WEBDIR?>' method='POST'>
            <div class="col-md-9">
                <div class="demande_item">
                    <label for="login">email :</label>
                    <input type='text' name='login'>
                </div>
                <div class="demande_item">
                    <label for="password">mot de passe :</label>
                    <input type='password' name='password' id="password">
                </div>
                <div class='reminder'>
                    <a href="<?=WEBDIR?>reminder/forget"><span id='btnreminder'>j'ai oublié mon mot de passe !</span></a>
                </div>
                <div class='keep'>
                    <span style='padding-left:59%;font-size:16px;cursor:pointer;color: #00a2b0;'>se souvenir de moi</span>
                    <input type="checkbox" name="check_demandecontact" id="check_demandecontact"/>
                    <label for="check_demandecontact" class="roundbox">

                </div>
                <div class="send2">
                    <input type="submit" value="c'est parti !">
                </div>
            </div>
            <div class="col-md-9 ">
                <div>
                    <img src="<?=WEBDIR?>/img/bonhommelogin.png" alt="" style="position: absolute;top: -74px;left: 52px;"/>
                </div>
                <div style="margin: 34% 33% 0 33%;">
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
                </div>
            </div>
        </form>
    </div>
</div>



