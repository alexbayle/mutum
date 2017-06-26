<div class="row2">
    <div class="col-md-18 title">
        <h1>mon classement</h1>
    </div>
    <div class="col-md-18 menu_onglet"style="padding-left: 0;padding-right: 0">
        <?php include_once('header.php') ?>
    </div>

    <div class="col-md-18 ranking">
        <div class="col-md-6" style="padding-left: 0;padding-right: 0;">
            <div class="col-md-18 general">

                <?php
                if($ranks['general'] == 1){
                    echo "<img src='/img/rank/piece1.png' alt=''/>";
                }else if($ranks['general'] == 2){
                    echo "<img src='/img/rank/piece2.png' alt=''/>";
                }else if($ranks['general'] == 3){
                    echo "<img src='/img/rank/piece3.png' alt=''/>";
                }else{
                    echo "";
                }
                ?>

                <p>général</p>
                <hr>
                <div style="text-align: center;">
                    <span style="font-size: 37px">
                        <?php echo $ranks['general'] ?>
                        <span style="font-size:25px;">sur <?php echo user::getAllUser(); ?></span>
                    </span>
                </div>
            </div>
            <div class="col-md-18 ville">
                <?php
                if($ranks['city'] == 1){
                    echo "<img src='/img/rank/piece1.png' alt=''/>";
                }else if($ranks['city'] == 2){
                    echo "<img src='/img/rank/piece2.png' alt=''/>";
                }else if($ranks['city'] == 3){
                    echo "<img src='/img/rank/piece3.png' alt=''/>";
                }else{
                    echo "";
                }
                ?>
                <p>ville</p>
                <hr>
                <div style="text-align: center;">
                    <span style="font-size: 37px">
                        <?php echo $ranks['city'] ?>
                        <span style="font-size:25px;">sur <?php echo user::getPeopleByCity(); ?></span>
                    </span>
                </div>
            </div>
            <div class="col-md-18 contact">
                <?php
                if($ranks['contact'] == 1){
                    echo "<img src='/img/rank/piece1.png' alt=''/>";
                }else if($ranks['contact'] == 2){
                    echo "<img src='/img/rank/piece2.png' alt=''/>";
                }else if($ranks['contact'] == 3){
                    echo "<img src='/img/rank/piece3.png' alt=''/>";
                }else{
                    echo "";
                }
                ?>
                <p>contact</p>
                <hr>
                <div style="text-align: center;">
                    <span style="font-size: 37px">
                        <?php echo $ranks['contact'] ?>
                        <span style="font-size:25px;">sur <?php echo contact::countMyContact(); ?></span>
                    </span>
                </div>
            </div>
            <?php if (false !== $ranks['community']) : ?>
                <div class="col-md-18 community">
                    <?php
                    if($ranks['community'] == 1){
                        echo "<img src='/img/rank/piece1.png' alt=''/>";
                    }else if($ranks['community'] == 2){
                        echo "<img src='/img/rank/piece2.png' alt=''/>";
                    }else if($ranks['community'] == 3){
                        echo "<img src='/img/rank/piece3.png' alt=''/>";
                    }else{
                        echo "";
                    }
                    ?>
                   <p>communauté</p>
                    <hr>
                    <div style="margin-left: 97px;">
                    <span style="font-size: 37px">
                        <?php echo $ranks['community'] ?>
                        <span style="font-size:25px;">sur 10</span>
                    </span>
                    </div>
                </div>
            <?php endif ?>

        </div>
        <div class="col-md-1 hr">
            <img src="<?=WEBDIR?>img/verticalbar.png" alt="" height="400px"/>
        </div>
        <div class="col-md-12 rank" >
            <div class="scrollbar" style="margin-top: 40px; height: 500px;overflow: auto;">
                <?php foreach ($users as $offset => $user) : ?>
                    <?php $offset++;?>
                        <?php if ($offset == 1 ){?>
                        <div class="col-md-18 row_rank" style="background-color: #ffdb7d;height: 100px;">
                            <div class="col-md-3" style="margin-top: 5%;">
                                <span><?php echo $offset === 1 ? sprintf("%ser", $offset) : sprintf("%sème", $offset) ?></span>
                            </div>
                            <div class="col-md-3" style="margin-top: 4%;">
                                <span><?php echo $user[0]->print_user(30, 'photo') ?></span>
                            </div>
                            <div class="col-md-3" style="margin-top: 5%;">
                                <span><?php echo sprintf("%s %s", $user[0]->getAttr('firstname'), strtoupper($user[0]->getAttr('lastname')[0])) ?></span>
                            </div>
                           <div class="col-md-2" style="margin-top: 4%;">
                               <span><?php echo $user[0]->printNote()?></span>
                           </div>
                           <div class="col-md-2" style="margin-top: 5%;">
                               <span><?php echo sprintf("(%s)", $user[0]->getAttr('nb_notation')) ?></span>
                           </div>
                           <div class="col-md-3" style="margin-top: 5%;">
                               <span style="font-size: 25px"><?php echo sprintf("%s pts", $user[0]->getAttr('score')) ?></span>
                           </div>
                           <div class="col-md-2">
                                <span><img src="<?=WEBDIR?>img/rank/rank1.png" alt=""/></span>
                           </div>
                        </div>
                        <?php }
                            else if($offset == 2){
                        ?>
                        <div class="col-md-18 row_rank" style="background-color: #9bd2d7;">
                            <div class="col-md-3" style="margin-top: 1%">
                                <span><?php echo $offset === 1 ? sprintf("%ser", $offset) : sprintf("%sème", $offset) ?></span>
                            </div>
                            <div class="col-md-3">
                                <span><?php echo $user[0]->print_user(30, 'photo') ?></span>
                            </div>
                            <div class="col-md-3" style="margin-top: 1%">
                                <span><?php echo sprintf("%s %s", $user[0]->getAttr('firstname'), strtoupper($user[0]->getAttr('lastname')[0])) ?></span>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo $user[0]->printNote()?></span>
                            </div>
                            <div class="col-md-2" style="margin-top: 1%">
                                <span><?php echo sprintf("(%s)", $user[0]->getAttr('nb_notation')) ?></span>
                            </div>
                            <div class="col-md-3" style="margin-top: 5px">
                                <span style="font-size: 25px"><?php echo sprintf("%s pts", $user[0]->getAttr('score')) ?></span>
                            </div>
                            <div class="col-md-2">
                                <span><img src="<?=WEBDIR?>img/rank/rank2.png" alt=""/></span>
                            </div>

                        </div>
                        <?php }
                            else if($offset == 3){
                        ?>
                        <div class="col-md-18 row_rank" style="background-color: #dcf0f2;">
                            <div class="col-md-3" style="margin-top: 1%">
                                <span><?php echo $offset === 1 ? sprintf("%ser", $offset) : sprintf("%sème", $offset) ?></span>
                            </div>
                            <div class="col-md-3">
                                <span><?php echo $user[0]->print_user(30, 'photo') ?></span>
                            </div>
                            <div class="col-md-3" style="margin-top: 1%">
                                <span><?php echo sprintf("%s %s", $user[0]->getAttr('firstname'), strtoupper($user[0]->getAttr('lastname')[0])) ?></span>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo $user[0]->printNote()?></span>
                            </div>
                            <div class="col-md-2" style="margin-top: 1%">
                                <span><?php echo sprintf("(%s)", $user[0]->getAttr('nb_notation')) ?></span>
                            </div>
                            <div class="col-md-3" style="margin-top: 5px">
                                <span style="font-size: 25px"><?php echo sprintf("%s pts", $user[0]->getAttr('score')) ?></span>
                            </div>
                            <div class="col-md-2">
                                <span><img src="<?=WEBDIR?>img/rank/rank3.png" alt=""/></span>
                            </div>

                        </div>
                        <?php }
                            else {
                        ?>
                        <div class="col-md-18 row_rank">
                            <div class="col-md-3" style="margin-top: 1%">
                                <span><?php echo $offset === 1 ? sprintf("%ser", $offset) : sprintf("%sème", $offset) ?></span>
                            </div>
                            <div class="col-md-3">
                                <span><?php echo $user[0]->print_user(30, 'photo') ?></span>
                            </div>
                            <div class="col-md-3" style="margin-top: 1%">
                                <span><?php echo sprintf("%s %s", $user[0]->getAttr('firstname'), strtoupper($user[0]->getAttr('lastname')[0])) ?></span>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo $user[0]->printNote()?></span>
                            </div>
                            <div class="col-md-2" style="margin-top: 1%">
                                <span><?php echo sprintf("(%s)", $user[0]->getAttr('nb_notation')) ?></span>
                            </div>
                            <div class="col-md-3" style="margin-top: 5px">
                                <span style="font-size: 25px"><?php echo sprintf("%s pts", $user[0]->getAttr('score')) ?></span>
                            </div>
                            <div class="col-md-2">

                            </div>
                         </div>
                     <?php
                        }
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>