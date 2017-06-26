<div class="row2">
    <div class="col-md-18 title">
        <h1>mes succès</h1>
    </div>
    <div class="col-md-18 menu_onglet" style="padding-left: 0;padding-right: 0">
        <?php include_once('header.php') ?>
    </div>

    <div class="col-md-18 succes">
        <div class="col-md-5 left">
            <div class="col-md-18">
                <img src=<?=user::linkAvatarImg(Session::Me()->user_id,Session::Me()->user_rank)?> alt="" style="width: 175%;margin: 0;margin-left: -25%;" />
            </div>
            <div class="col-md-18 infos">
                <p class="nom"><?php echo \Session::Me()->printName() ?></p><br />
                <p><?php echo rank::getMyRankName(Session::Me()->getAttr('id')); ?></p><br />
                <p><?php echo $nbArticles ?> objets </p>
            </div>
        </div>

        <div class="col-md-11 right " style="  margin-left: 80px;">
            <div class="col-md-18 successBox" style="  margin-top: 75px; ">
                <div class="col-md-18" style="/*height: 170px;*/ margin-top: -25px;">
                    <div class="col-md-18" style="/*margin: 10% 21% 0% 20%;*/     margin-left: 18%;">
                        <img src=<?=WEBDIR.'img/personnageRangs/niv_1/'.\user::getAvatarNb(Session::Me()->user_id).'.png'?> style='width:80px;margin-right:-25px;margin-left: -5px;<?php if(Session::Me()->user_rank<1) echo "opacity:0.2" ?>'>
                        <img src=<?=WEBDIR.'img/personnageRangs/niv_2/'.\user::getAvatarNb(Session::Me()->user_id).'.png'?> style='width:80px;margin-right:-25px;<?php if(Session::Me()->user_rank<2) echo "opacity:0.2" ?>'>
                        <img src=<?=WEBDIR.'img/personnageRangs/niv_3/'.\user::getAvatarNb(Session::Me()->user_id).'.png'?> style='width:80px;margin-right:-25px;<?php if(Session::Me()->user_rank<3) echo "opacity:0.2" ?>'>
                        <img src=<?=WEBDIR.'img/personnageRangs/niv_4/'.\user::getAvatarNb(Session::Me()->user_id).'.png'?> style='width:80px;margin-right:-25px;<?php if(Session::Me()->user_rank<4) echo "opacity:0.2" ?>'>
                        <img src=<?=WEBDIR.'img/personnageRangs/niv_5/'.\user::getAvatarNb(Session::Me()->user_id).'.png'?> style='width:80px;margin-right:-25px;<?php if(Session::Me()->user_rank<5) echo "opacity:0.2" ?>'>

                    </div>
                    <div class="progress_bar col-md-18" style="margin: 0% 24% 0% 20%;">
                        <img src="<?= WEBDIR ?>img/arrow-top-grey.png" alt="" style="position:absolute;  z-index: 9999;top: 15px;left: <?php echo (achievements::getPourcentAchievements()/100*288+4); ?>px; "/> <!-- (left) min:5px // max: 293px-->
                                <div style="float: left">
                            <div class="progress_bar_front progress_bar_first" style="float: left;z-index: 999;width: <?php if($progressBar>56*1) echo '56'; else echo $progressBar; ?>px;"></div>
                            <div class="progress_bar_back progress_bar_first"></div>
                        </div>
                        <div style="float: left">
                            <div class="progress_bar_front progress_bar_first" style="float: left;z-index: 999;width: <?php if($progressBar>56*2) echo '56'; else echo $progressBar-56*1; ?>px;"></div>
                            <div class="progress_bar_back"></div>
                        </div>
                        <div style="float: left">
                            <div class="progress_bar_front progress_bar_first" style="float: left;z-index: 999;width: <?php if($progressBar>56*3) echo '56'; else echo $progressBar-56*2; ?>px;"></div>
                            <div class="progress_bar_back"></div>
                        </div>
                        <div style="float: left">
                            <div class="progress_bar_front progress_bar_first" style="float: left;z-index: 999;width: <?php if($progressBar>56*4) echo '56'; else echo $progressBar-56*3; ?>px;"></div>
                            <div class="progress_bar_back"></div>
                        </div>
                        <div style="float: left">
                            <div class="progress_bar_front progress_bar_first" style="float: left;z-index: 999;width: <?php if($progressBar>56*5) echo '56'; else echo $progressBar-56*4; ?>px;"></div>
                            <div class="progress_bar_back progress_bar_last"></div>
                        </div>
                        <div >
                            <img src="<?= WEBDIR ?>img/pile-money-01.png" alt=""
                                 style="  width: 40px;height: 40px;box-shadow: none;position: absolute;top: -14px;left: 317px;background-color: white;padding: 4px;border-radius: 4000px;"/>
                            <div style="position: absolute;top: 2px;left: 331px;font-size: <?php if($mutumGagnes<100) echo '16'; else echo '13' ?>px;z-index: 1;font-family: bariolBold;color: white;"><?=$mutumGagnes?></div>
                        </div>
                    </div>
                    <div class="col-md-18" style="margin: 3% 40% 0% 39%;">
                       <p style="background-color: white;border-radius: 5px;padding: 5px;  width: 40%;text-align: center;margin-left: -40px;font-weight : bold;"> prochain niveau : <?php echo rank::getMyNextRankName(Session::Me()->getAttr('id')); ?></p><br />
                    </div>
                </div>
                <div class="col-md-18" style="/* height: 200px; */padding: 20px;">
                    <?php foreach ($achievements as $achievement) : ?>
                        <div style="font-weight: <?php echo $achievement['done'] ? 'bold' : '' ?>;">
                            <div class="col-md-14">
                                <?php echo $achievement['achi_title'] ?>
                            </div>
                            <div class="col-md-1">
                                <?php echo $achievement['achi_win'] ?>
                            </div>
                            <div class="col-md-1">
                                <?php
                                if($achievement['done']){
                                    echo "<img src='/img/success/successdone.png' alt=''> ";
                                }else{
                                    echo "<img src='/img/success/successundone.png' alt=''> ";
                                }
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-18 easteregg">
                <div class="col-md-18" style="padding: 20px;">
                    <?php foreach ($easterEggs as $easterEggs) : ?>
                        <div style="font-weight: <?php echo $easterEggs['done'] ? 'bold' : '' ?>;">
                            <div class="col-md-14">
                                <?php echo $easterEggs['achi_title'] ?>&nbsp;
								<div class="new-info1" style="display:inline;">
								<img src="/img/info-icon.png" onMouseOut="this.src='/img/info-icon.png'" onMouseOver="this.src='/img/info-icon-hover.png'">
									<span class="new-info">
										nos développeurs sont des petits rigolos, retrouvez ce qu'ils ont caché sur le site !
									</span>
								</div>
                            </div>							
                            <div class="col-md-1">
                                <?php echo $easterEggs['achi_win'] ?>
                            </div>
                            <div class="col-md-1">
                                <?php
                                if($easterEggs['done']){
                                    echo "<img src='/img/success/successdone.png' alt=''> ";
                                }else{
                                    echo "<img src='/img/success/successundone.png' alt=''> ";
                                }
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="paques">
                    <img src="<?=WEBDIR?>img/success/easter.png" alt=""/>
                </div>
            </div>

        </div>
    </div>

</div>