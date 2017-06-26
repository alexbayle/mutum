<?php
    if($myAsks != array()) {
        foreach($myAsks as $m) {
            if($m[0]->getAttr('id') != Session::Me()->getAttr('id')) {
?>
                <div class='col-md-9 unContact' style="width: 385px;margin-left: 10px;margin-right: 10px;background-color: #ffdb7d;">
                    <div class="col-md-4" style="margin-top: 8px;padding: 0;">
                        <?=$m[0]->print_user(80,'profile');?>
                    </div>
                    <div class="col-md-8" style="margin-top: 20px;">
                        <div>
                            <a class='blue' href="<?=WEBDIR?>user?module=<?=$m[0]->getAttr('id');?>"><?=$m[0]->printName();?></a>
                        </div>
                        <div style="position: absolute;top: -8px;left: 120px;">
                            <?=$m[0]->printNote();?>
                        </div>
                        <div>
                            <?=product::getNumberProducts($m[0]->getAttr('id'));?> objets
                        </div>
                        <div>
                            <?php echo contact::countMyContact(); ?> amis en commun
                        </div>
                        <div>
                            <img src="<?=WEBDIR?>img/contact/ville.png" alt=""/>&nbsp;<?php echo user::getCity($m[0]->getAttr('address'));  ?>
                        </div>
                    </div>
                    <div class="col-md-6 button" style="padding: 0;">
                        <form action='inbox' method='GET'>
                            <input name='module' type='hidden' value='<?=$m[0]->getAttr('id');?>' />
                            <button type='submit' class="sendmsg">message</button>
                        </form>
                        <form action='' method='GET'>
                            <input name='cancel_ask' type='hidden' value='<?=$m[0]->getAttr('id');?>' />
                            <button type="submit" class="send">annuler la demande</button>
                        </form>
                    </div>
                </div>

<?php
            }
        }
    } else {
?>
        <div style='margin-left:5px;'>
            vous n'avez pas de demande en attente.
        </div>
<?php
    }
?>