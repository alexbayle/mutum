<div class="row">
    <div class="col-md-18 title">
        <h1>mon compte</h1>
    </div>
    <div class="rowWrap" >
        <div class="AccountBannerContent" >
            <section class="col-md-4 col-xs-18">
                <img src=<?=user::linkAvatarImg(Session::Me()->user_id,Session::Me()->user_rank)?> style="width:125%;margin: -15%;" alt="mutum" title="Mon profil Mutum"/>
            </section>
            <section class="col-xs-18 col-md-5 ">
                <div class="row">
                    <div class=" col-md-18 col-lg-18 col-xs-18">
                        <p class="userStatut"><strong><?php echo $user->printRank()[0]['rank_name'];?></strong></p>
                        <span class="userLevel"><?php echo user::printNextRank($user->printRank()[0]['rank_name']); ?></span><br><br>

                        <p class="nbSuccess"><span class="userSuccess"><?php echo count(achievements::getMyOwnAchievementsByCat(\Session::Me()->getAttr('id'))); ?></span> / <?php echo achievements::countAchievementsByCat() ?> succès</p>
                        <progress class="jaugeSuccess" value="<?php echo count(achievements::getMyOwnAchievementsByCat(\Session::Me()->getAttr('id'))); ?>" max="<?php echo achievements::countAchievementsByCat() ?>" form="form-id"></progress>
                    </div>
                </div>
            </section>
            <section class="col-md-7 col-xs-offset-0  userInfos">
                <div class="row">
                    <section class="col-md-18 col-lg-18 col-xs-18">
                        <div class="userName">
                            <?php
                            $note_user = DB::SqlOne("SELECT user_notation FROM user WHERE user_id=".Session::Me()->getAttr('id'));
                            \user::printNoteUser(round($note_user));
                            echo $user->printName();

                            ?>
                        </div>
                    </section>
                </div>
                <div class="row">
                    <p class="userData col-md-18 col-lg-18 col-xs-18" style="margin-top: 10px;">inscrit(e) le : <span class="labelUserInfo">
                            <?php
                            echo Session::Me()->getAttr('date_creation');
                            ?></span></p>
                    <p class="userData col-md-18 col-lg-18 col-xs-18" >
                        adresse complète : <span class="labelUserInfo"><?php echo Session::myLoc()->getAddress(); ?></span>
                    </p>
                    <p class="userData col-md-18 col-lg-18 " >email : <span class="labelUserInfo"><?php echo Session::Me()->GetAttr('email'); ?></span></p>
                </div>
            </section>
            <section class="col-md-2 col-xs-18">
                <div class="avatar"><?php  echo $user->print_user(80);?></div>
            </section>

            <div class="col-md-10  " style="padding: 0;    margin-left: 1%;">

                <p class="rsfollowTitle userSuccess"><strong>vos derniers succès :</strong></p>

                <?php if($myAchievements != array()){ ?>
                    <?php foreach ($myAchievements as $key => $value): ?>
                        <?php if ($key <= 5): ?>

                            <div class="col-md-9" style="margin-top: 5px;padding: 0;">
                                <?php echo($value['achi_title']); ?>
                            </div>
                            <div class="col-md-1" style="margin-top: 5px;padding: 0;">
                                                <span class="userSuccess col-xs-offset-0">
                                                    <?php echo($value['achi_win']); ?>
                                                </span>
                            </div>
                            <div class="col-md-1" style="padding: 0;;">
                                <img src='/img/success/successdone.png' alt='' style="margin-top: 5px;" ">
                            </div>

                        <?php endif; ?>
                    <?php endforeach ?>
                <?php }else{ ?>
                    <span style="color:#515151;">vous n'avez pas réalisé de succès</span>
                <?php } ?>

            </div>
            <section class="col-md-18">
                <form method='POST'>
                    <input type='submit' name='btneddit' class="edit" value='éditer'>
                </form>
            </section>
        </div>
    </div>
</div>

<div class="row">
    <div class="rowWrap" >
        <section class="col-md-9 " style="">
            <div class=" mutumInfos row">
                <div class="mutumInfosContainer">
                    <div class = "row col-md-18 col-xs-18  col-lg-18 col-xs-18">
                        <section class="col-md-9">
                            <img class="img-responsive" src="img/pile_mutum.png" alt="mutum" title="Vos Mutums"/>
                        </section>
                        <section class="col-md-9 col-xs-18 ">
                            <div class="row">
                                <p class="userStatut"><strong>vos mutums</strong></p>
                                <p><span class="nbMutums"><?php echo Session::Me()->GetAttr('credit'); ?></span><span style="margin-left: 5px;"><img  class="mutum-icon" src="img/petit_mutum.png"/></span></p></br>
                                <a href="<?=WEBDIR?>success/wallet"><p><input type="button" class="btnAllMutum" value="tous vos mutums"></p><br/></a>
                            </div>

                            <hr class="infoSeparator">
                            <div class="row">
                                <p class="mutumInfoTitle">relevé de mutums : </p>
                            </div>
                        </section>
                        <section class="col-md-18" style="padding: 0;width: 105%">
                            <div class="row">
                                <?php if(Session::Me()->getHistoryWithCat3() != array()){ ?>
                                    <?php foreach (\Session::Me()->getHistoryWithCat3() as $elm) { ?>

                                        <div class="col-md-18" style="padding-top: 5px;">
                                            <div class="col-md-11" style="padding: 0;color: #515151;">
                                                <?php if($elm[0]->getAttr('type') == "Référencement d'un nouvel objet")
                                                    echo "Reférencement objet";
                                                else
                                                    echo $elm[0]->getAttr('type')
                                                ?>
                                            </div>
                                            <div class="col-md-4" style="padding: 0;color: #515151;">
                                                <?php echo $elm[1]->getAttr('name') ?>
                                            </div>
                                            <div class="col-md-2" style="padding: 0;color: #515151;text-align: right;">
                                                <?php echo $elm[1]->getAttr('win') ?>
                                            </div>
                                            <div class="col-md-1" style="padding: 0">
                                                <img src="<?php WEBDIR ?>img/success/successdone.png" alt="" width="12" height="12">
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <p><br/>&nbsp;vous n'avez pas de relevé disponible.</p>
                                <?php } ?>
                            </div>
                        </section>


                    </div>
                </div>
            </div>
        </section>
        <section class="col-md-9 col-xs-18">
            <div class="row">
                <div class="lastMutumActions">
                    <div class="dernierPret col-md-18 col-lg-18">
                        <?php //var_dump($lendInProgress); ?>
                        <?php if($lendInProgress != array() && $lendInProgress[0][0]->getAttr('date_from') <= date('Y-m-d') && $lendInProgress[0][0]->getAttr('date_to') >= date('Y-m-d') ){ ?>
                            <div class="col-md-12">
                                <p class="labelDernierPret">mon dernier prêt</p>
                                <p class="contenuDernierPret"><?php echo $lendInProgress[0][2]->getAttr('name'); ?> - <?php echo $lendInProgress[0][0]->calculDateDiff() ?></p>
                                <div class="jauge">
                                    <progress value="<?php echo $lendInProgress[0][0]->calculDatePourcentage() ?>" max="100" form="form-id"></progress>

                                </div>
                            </div>
                            <div class="col-md-6" style="padding: 20px;">
                                <?php echo $lendInProgress[0][3]->print_picture(100,'round');?>
                            </div>
                        <?php }else{ ?>
                            <p class="labelDernierPret">mon dernier prêt</p>
                            <span class="blue">vous n'avez pas de prêt en cours</span>
                        <?php } ?>
                    </div>


                    <div class="col-md-18 col-xs-18 col-lg-18">
                        <hr class="infoLastInfo ">
                    </div>

                    <div class="dernierEmprunt col-md-18 col-lg-18  ">
                        <?php //var_dump($borrowInProgress); ?>
                        <?php if($borrowInProgress != array() && $borrowInProgress[0][0]->getAttr('date_from') <= date('Y-m-d') && $borrowInProgress[0][0]->getAttr('date_to') >= date('Y-m-d')){ ?>
                            <div class="col-md-12">
                                <p class="labeldernierEmprunt">mon dernier emprunt</p>
                                <p class="contenuEmprunt"><?php echo $borrowInProgress[0][2]->getAttr('name'); ?> - <?php echo $borrowInProgress[0][0]->calculDateDiff() ?></p>
                                <div class="jaugeRed">
                                    <progress value="<?php echo $borrowInProgress[0][0]->calculDatePourcentage() ?>" max="100" form="form-id"></progress>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding: 20px;">
                                <?php echo $borrowInProgress[0][3]->print_picture(100,'round'); ?>
                            </div>
                        <?php }else{ ?>
                            <p class="labeldernierEmprunt">mon dernier emprunt</p>
                            <p>vous n'avez pas d'emprunt en cours</p>
                        <?php }?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="row" >
    <div class="rowWrap col-md-18 col-md-18 col-xs-18" style="margin-top: 10px;">
        <div class="col-md-9 col-xs-18 moduleWrap" >
            <div class="lastMutumActions">
                <div class="dernierPret">
                    <div class="row ">
                        <div class="col-md-18 col-lg-18">
                            <p class="labelDernierPret ">mes objets :</p><br>
                            <p class="contenuDernierPret">vous avez encore <span class="userData"><?php echo count($user->getNumberArticleDispo(Session::Me()->GetAttr('id'))); ?> objet(s) </span>à échanger</p><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-18 col-lg-18 col-xs-18">
                            <?php foreach ($user->getUserArticleDispo(Session::Me()->GetAttr('id')) as $key => $value): ?>
                                <a class="userProductRest col-md-4" href="">
                                    <?=$value[1]->print_picture(80, 'round')?>
                                </a>
                                <!--p class="contenuDernierPret"><?php //echo($value->prod_name);  ?></p-->
                                <?php //echo($value->prod_desc);  ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-18 col-xs-18 col-lg-18">
                            <br><hr class="infoLastInfo"><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-0 col-xs-18 col-xs-offset-0 " >
                            <p>nombre d'objets : <span class="userData"><?php echo count($user->getUserArticle(Session::Me()->GetAttr('id'))); ?></span></p>
                            <p>avis prêteur : <span class="userData"><?php echo sizeof($user->getNotePreteur()); ?></span></p>

                            <p>avis emprunteur : <span class="userData"><?php echo sizeof($user->getNoteEmpreinteur()); ?></span></p>
                        </div>
                        <div style="padding:10px; margin-top:20px">
                            <a class="btn col-md-8 col-xs-18 btnProfile " href="items" style="width: 240px; margin-left: 15px;">voir mes objets</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-xs-18" >&nbsp;</div>
    </div>
</div>

