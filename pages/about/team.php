<style>
    .content div{
        text-align: center;
    }
    .nom{
        font-size: 18px;
        color: #00a2b0;
        text-align: center;
        background-color: white;
        padding: 4px;
        margin-top: 10px;
    }
    .fonction{
        margin-top: 5px;
        text-align: center;
        color: #999999;
        font-size: 12px;

    }

    .social img{
        opacity : 0.6;
        margin: 5px 2px;
    }
    .social img:hover{
        opacity : 1;
    }

    .desc{
        width: 150%;
        margin-left: -25%;
    }

    .objet{
        padding-top: 5px;
        font-size: 12px;
        color: #00a2b0;
        opacity : 0.5;
    }

    .note{
        display: inline-block;
    }
    .note img{
        padding: 2px;
        margin-top: 4px;
    }

    .col-md-2{
        padding:  0
    }

    .onglet_1{
        margin-left: 10px;
    }

</style>


    <div class="col-md-18 title">
        <h1>l'équipe</h1>
    </div>
    <div class="col-md-18 menu_onglet"style="padding-left: 0;padding-right: 0">
        <?php include_once('header.php') ?>
    </div>
<div class="row2">
    <div class="col-md-18 ranking" style="padding: 50px 0">
        <!-- faudra virer le style/margin pour passer à un affichage 5/ligne -->
       <div class="col-md-offset-2 col-md-2" style=" margin-left: 200px;">
            <div class="col-md-18">
                <img src="<?=WEBDIR?>img/team/teamPic_anouck.png" style="width: 100%;"/>
            </div>
           <div class="col-md-18">
               <p class="nom desc">Anouck</p>
               <p class="desc objet">objets : <?php echo DB::SqlOne("SELECT count(*) FROM user,product WHERE user_firstname = 'Anouck' AND user_lastname = 'Alarcon ' AND prod_user_id=user_id") ?></p>
               <p class="note desc">
                   <?php
                        $note_user = DB::SqlOne("SELECT user_notation FROM user WHERE user_firstname = 'Anouck' AND user_lastname = 'Alarcon'");
                        for($i=1;$i<=5;$i++){
                            if($note_user<$i) echo "<img src='".WEBDIR."img/note_userB.png'/>";
                            else echo "<img src='".WEBDIR."img/note_user.png'/>";
                        }
                   ?>
               </p>
               <p class="fonction desc">community manager</p>
               <p class="desc">
                   <a href="https://fr.linkedin.com/pub/anouck-alarcon/85/434/3b8" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64linkedin.png" style="height: 20px;width: 20px"/></a>
                   <a href="https://twitter.com/AnouckA_" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64twitter.png" style="height: 20px;width: 20px"/></a>
               </p>
           </div>
       </div>
        <div class="col-md-offset-1 col-md-2">
            <div class="col-md-18">
                <img src="<?=WEBDIR?>img/team/teamPic_fred.png" style="margin-left: -25px;width: 130%;display: inline-block"/>
                <p class="nom desc">Frédéric</p>
                <p class="desc objet">objets : <?php echo DB::SqlOne("SELECT count(*) FROM user,product WHERE user_firstname = 'Frédéric' AND user_lastname = 'Griffaton ' AND prod_user_id=user_id") ?></p>
                <p class="note desc">
                    <?php
                    $note_user = DB::SqlOne("SELECT user_notation FROM user WHERE user_firstname = 'Frédéric' AND user_lastname = 'Griffaton'");
                    for($i=1;$i<=5;$i++){
                        if($note_user<$i) echo "<img src='".WEBDIR."img/note_userB.png'/>";
                        else echo "<img src='".WEBDIR."img/note_user.png'/>";
                    }
                    ?>
                </p>
                <p class="fonction desc">co-fondateur &<br/> président</p>
                <p class="desc">
                    <a href="https://fr.linkedin.com/pub/frédéric-griffaton/61/22b/1b6" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64linkedin.png" style="height: 20px;width: 20px"/></a>
                    <a href="https://twitter.com/FGriffaton" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64twitter.png" style="height: 20px;width: 20px"/></a>
                </p>
            </div>
        </div>
        <div class="col-md-offset-1 col-md-2">
            <div class="col-md-18">
                <img src="<?=WEBDIR?>img/team/teamPic_math.png" style="width: 103%;display: inline-block"/>

                <p class="nom desc">Mathieu</p>
                <p class="desc objet">objets : <?php echo DB::SqlOne("SELECT count(*) FROM user,product WHERE user_firstname = 'Mathieu' AND user_lastname = 'Jeanne-Beylot' AND prod_user_id=user_id") ?></p>
                <p class="note desc">
                    <?php
                    $note_user = DB::SqlOne("SELECT user_notation FROM user WHERE user_firstname = 'Mathieu' AND user_lastname = 'Jeanne-Beylot'");
                    for($i=1;$i<=5;$i++){
                        if($note_user<$i) echo "<img src='".WEBDIR."img/note_userB.png'/>";
                        else echo "<img src='".WEBDIR."img/note_user.png'/>";
                    }
                    ?>
                </p>
                <p class="fonction desc">co-fondateur & <br/>directeur général</p>
                <p class="desc">
                    <a href="https://fr.linkedin.com/pub/mathieu-jeanne-beylot/35/59b/b89" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64linkedin.png" style="height: 20px;width: 20px"/></a>
                    <a href="https://twitter.com/Mathieuje" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64twitter.png" style="height: 20px;width: 20px"/></a>
                </p>
            </div>

        </div>
        <div class="col-md-offset-1 col-md-2">
            <div class="col-md-18">
                <img src="<?=WEBDIR?>img/team/teamPic_livio.png" style="margin-top: -16px;width: 100%;"/>
            </div>
            <div class="col-md-18">
                <p class="nom desc">Livio</p>
                <p class="desc objet">objets : <?php echo DB::SqlOne("SELECT count(*) FROM user,product WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz' AND prod_user_id=user_id") ?></p>
                <p class="note desc">
                    <?php
                    $note_user = DB::SqlOne("SELECT user_notation FROM user WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz'");
                    for($i=1;$i<=5;$i++){
                        if($note_user<$i) echo "<img src='".WEBDIR."img/note_userB.png'/>";
                        else echo "<img src='".WEBDIR."img/note_user.png'/>";
                    }
                    ?>
                </p>
                <p class="fonction desc">graphiste</p>
                <p class="desc">
                    <a href="https://fr.linkedin.com/in/steinmetzolivier" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64linkedin.png" style="height: 20px;width: 20px"/></a>
                    <a href="https://twitter.com/Livio_ST" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64twitter.png" style="height: 20px;width: 20px"/></a>
                    <a href="https://fr.pinterest.com/liviosteinmetz" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64pinterest.png" style="height: 20px;width: 20px"/></a>
                </p>
            </div>
        </div>

        <!--
        <div class="col-md-offset-1 col-md-2">
            <div class="col-md-18">
                <img src="<?=WEBDIR?>img/team/teamPic_livio.png" style="width: 100%;"/>
            </div>
            <div class="col-md-18">
                <p class="nom desc">Livio</p>
                <p class="desc objet">Objets : <?php echo DB::SqlOne("SELECT count(*) FROM user,product WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz' AND prod_user_id=user_id") ?></p>
                <p class="note desc">
                    <?php
                    $note_user = DB::SqlOne("SELECT user_notation FROM user WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz'");
                    for($i=1;$i<=5;$i++){
                        if($note_user<$i) echo "<img src='".WEBDIR."img/note_userB.png'/>";
                        else echo "<img src='".WEBDIR."img/note_user.png'/>";
                    }
                    ?>
                </p>
                <p class="fonction desc">Graphiste</p>
                <p class="desc">
                    <a href="https://fr.linkedin.com/in/steinmetzolivier" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64linkedin.png" style="height: 20px;width: 20px"/></a>
                    <a href="" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64twitter.png" style="height: 20px;width: 20px"/></a>
                    <a href="" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64pinterest.png" style="height: 20px;width: 20px"/></a>
                </p>
            </div>
        </div> -->

        <!-- 2èeme ligne  -->

<!--
        <div class="col-md-offset-2 col-md-2" style="padding: 50px 0">
            <div class="col-md-18">
                <img src="http://www.hit4hit.org/img/login/user-icon-6.png" style="width: 100%;"/>
            </div>
            <div class="col-md-18">
                <p class="nom desc">Livio</p>
                <p class="desc objet">Objets : <?php echo DB::SqlOne("SELECT count(*) FROM user,product WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz' AND prod_user_id=user_id") ?></p>
                <p class="note desc">
                    <?php
                    $note_user = DB::SqlOne("SELECT user_notation FROM user WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz'");
                    for($i=1;$i<=5;$i++){
                        if($note_user<$i) echo "<img src='".WEBDIR."img/note_userB.png'/>";
                        else echo "<img src='".WEBDIR."img/note_user.png'/>";
                    }
                    ?>
                </p>
                <p class="fonction desc">Graphiste</p>
                <p class="desc">
                    <a href="https://fr.linkedin.com/in/steinmetzolivier" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64linkedin.png" style="height: 20px;width: 20px"/></a>
                    <a href="" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64twitter.png" style="height: 20px;width: 20px"/></a>
                    <a href="" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64pinterest.png" style="height: 20px;width: 20px"/></a>
                </p>
            </div>
        </div>


        <div class="col-md-offset-1 col-md-2" style="padding: 50px 0">
            <div class="col-md-18">
                <img src="http://www.hit4hit.org/img/login/user-icon-6.png" style="width: 100%;"/>
            </div>
            <div class="col-md-18">
                <p class="nom desc">Livio</p>
                <p class="desc objet">Objets : <?php echo DB::SqlOne("SELECT count(*) FROM user,product WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz' AND prod_user_id=user_id") ?></p>
                <p class="note desc">
                    <?php
                    $note_user = DB::SqlOne("SELECT user_notation FROM user WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz'");
                    for($i=1;$i<=5;$i++){
                        if($note_user<$i) echo "<img src='".WEBDIR."img/note_userB.png'/>";
                        else echo "<img src='".WEBDIR."img/note_user.png'/>";
                    }
                    ?>
                </p>
                <p class="fonction desc">Graphiste</p>
                <p class="desc">
                    <a href="https://fr.linkedin.com/in/steinmetzolivier" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64linkedin.png" style="height: 20px;width: 20px"/></a>
                    <a href="" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64twitter.png" style="height: 20px;width: 20px"/></a>
                    <a href="" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64pinterest.png" style="height: 20px;width: 20px"/></a>
                </p>
            </div>
        </div>


        <div class="col-md-offset-1 col-md-2" style="padding: 50px 0">
            <div class="col-md-18">
                <img src="http://www.hit4hit.org/img/login/user-icon-6.png" style="width: 100%;"/>
            </div>
            <div class="col-md-18">
                <p class="nom desc">Livio</p>
                <p class="desc objet">Objets : <?php echo DB::SqlOne("SELECT count(*) FROM user,product WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz' AND prod_user_id=user_id") ?></p>
                <p class="note desc">
                    <?php
                    $note_user = DB::SqlOne("SELECT user_notation FROM user WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz'");
                    for($i=1;$i<=5;$i++){
                        if($note_user<$i) echo "<img src='".WEBDIR."img/note_userB.png'/>";
                        else echo "<img src='".WEBDIR."img/note_user.png'/>";
                    }
                    ?>
                </p>
                <p class="fonction desc">Graphiste</p>
                <p class="desc">
                    <a href="https://fr.linkedin.com/in/steinmetzolivier" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64linkedin.png" style="height: 20px;width: 20px"/></a>
                    <a href="" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64twitter.png" style="height: 20px;width: 20px"/></a>
                    <a href="" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64pinterest.png" style="height: 20px;width: 20px"/></a>
                </p>
            </div>
        </div>


        <div class="col-md-offset-1 col-md-2" style="padding: 50px 0">
            <div class="col-md-18">
                <img src="http://www.hit4hit.org/img/login/user-icon-6.png" style="width: 100%;"/>
            </div>
            <div class="col-md-18">
                <p class="nom desc">Livio</p>
                <p class="desc objet">Objets : <?php echo DB::SqlOne("SELECT count(*) FROM user,product WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz' AND prod_user_id=user_id") ?></p>
                <p class="note desc">
                    <?php
                    $note_user = DB::SqlOne("SELECT user_notation FROM user WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz'");
                    for($i=1;$i<=5;$i++){
                        if($note_user<$i) echo "<img src='".WEBDIR."img/note_userB.png'/>";
                        else echo "<img src='".WEBDIR."img/note_user.png'/>";
                    }
                    ?>
                </p>
                <p class="fonction desc">Graphiste</p>
                <p class="desc">
                    <a href="https://fr.linkedin.com/in/steinmetzolivier" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64linkedin.png" style="height: 20px;width: 20px"/></a>
                    <a href="" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64twitter.png" style="height: 20px;width: 20px"/></a>
                    <a href="" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64pinterest.png" style="height: 20px;width: 20px"/></a>
                </p>
            </div>
        </div>



        <div class="col-md-offset-1 col-md-2" style="padding: 50px 0">
            <div class="col-md-18">
                <img src="http://www.hit4hit.org/img/login/user-icon-6.png" style="width: 100%;"/>
            </div>
            <div class="col-md-18">
                <p class="nom desc">Livio</p>
                <p class="desc objet">Objets : <?php echo DB::SqlOne("SELECT count(*) FROM user,product WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz' AND prod_user_id=user_id") ?></p>
                <p class="note desc">
                    <?php
                    $note_user = DB::SqlOne("SELECT user_notation FROM user WHERE user_firstname = 'Livio' AND user_lastname = 'Steinmetz'");
                    for($i=1;$i<=5;$i++){
                        if($note_user<$i) echo "<img src='".WEBDIR."img/note_userB.png'/>";
                        else echo "<img src='".WEBDIR."img/note_user.png'/>";
                    }
                    ?>
                </p>
                <p class="fonction desc">Graphiste</p>
                <p class="desc">
                    <a href="https://fr.linkedin.com/in/steinmetzolivier" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64linkedin.png" style="height: 20px;width: 20px"/></a>
                    <a href="" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64twitter.png" style="height: 20px;width: 20px"/></a>
                    <a href="" class="social"> <img src="<?=WEBDIR?>img/social/64x64/64x64pinterest.png" style="height: 20px;width: 20px"/></a>
                </p>
            </div>
        </div>

-->





    </div>
</div>
