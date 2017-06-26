<?php
if($waitingAsks != array()) {
    foreach($waitingAsks as $w) {
        if($w[0]->getAttr('id') != Session::Me()->getAttr('id')) {
            ?>
            <div class='col-md-9 unContact' style="width: 385px;margin-left: 10px;margin-right: 10px;">
                <div class="col-md-4" style="margin-top: 8px;padding: 0;">
                    <?=$w[0]->print_user(80,'profile');?>
                </div>
                <div class="col-md-8" style="margin-top: 20px;">
                    <div>
                        <a class='blue' href="<?=WEBDIR?>user?module=<?=$w[0]->getAttr('id');?>"><?=$w[0]->printName();?></a>
                    </div>
                    <div style="position: absolute;top: -8px;left: 120px;">
                        <?=$w[0]->printNote();?>
                    </div>
                    <div>
                        <?php echo product::getNumberProducts($w[0]->getAttr('id'));?> objets
                    </div>
                    <div>
                        <?php echo contact::countMyContact(); ?> amis en commun
                    </div>
                    <div>
                        <img src="<?=WEBDIR?>img/contact/ville.png" alt=""/>&nbsp;<?php echo user::getCity($w[0]->getAttr('address'));  ?>
                    </div>
                </div>
                <div class="col-md-6 button" style="padding: 0;">
                    <form action='' method='GET'>
                        <input name='accept_friend' type='hidden' value='<?=$w[0]->getAttr('id');?>' />
                        <button type="submit" class="ajout">valider</button>
                    </form>
                    <form action='' method='GET'>
                        <input name='ignore_friend' type='hidden' value='<?=$w[0]->getAttr('id');?>' />
                        <button type='submit' class="send">ignorer</button>
                    </form>
                </div>
            </div>

        <?php
        }
    }
} else {
    ?>
    <div style='margin-left:5px;'>
        vous n'avez reçu aucune demande.
    </div>
<?php
}
?>