<div class="row2">
    <div class="col-md-18 title">
        <h1>notifications e-mail</h1>
    </div>
    <div class="col-md-18 menu_onglet"style="padding-left: 0;padding-right: 0">
        <?php include_once('header.php') ?>
    </div>

    <div class="col-md-18 preter" style="
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
        <form action="" method="post">
            <?php foreach($notificationCat as $notCat){ ?>
                <div class="col-md-18">
                    <h2><?php echo $notCat[0]->getAttr('name') ?></h2>
                </div>
                <?php foreach(notification_mail::getNotificationMail($notCat[0]->getAttr('id')) as $notMail){ ?>
                    <div class="col-md-18" style="margin-top: 10px">
                        <div class="col-md-16" style="padding: 0;">
                            <span style="padding-left: 5%;"><?php echo $notMail[0]->getAttr('name') ?></span>
                        </div>
                        <div class="col-md-2" style="padding: 0;">
                            <div class='slideThree'>
                                <input type='checkbox' value='yes' <?php echo notification_user::getNotifUser(Session::Me()->getAttr('id'),$notMail[0]->getAttr('id')) > 0 ? " " : "checked"  ?>
                                       id="slideThree_<?php echo $notMail[0]->getAttr('id') ?>" name="check_<?php echo $notMail[0]->getAttr('id') ?>" />

                                <label for="slideThree_<?php echo $notMail[0]->getAttr('id') ?>"></label>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="send" style="float: right;padding-top: 10px;margin-right: 41%">
                <input type="submit" value="sauvegarder" name="valider"/>
            </div>
        </form>
    </div>
</div>