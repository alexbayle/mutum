<?php
    if($contacts != array()) {
        foreach($contacts as $c) {
            if($c[0]->getAttr('id') != Session::Me()->getAttr('id')) {
?>
                <div class='col-md-9 unContact <?=user::getCity($c[0]->getAttr('address'));?>' style="width: 385px;margin-left: 10px;margin-right: 10px;">
                    <div class="col-md-4" style="margin-top: 8px;padding: 0;">
                        <?=$c[0]->print_user(80,'profile');?>
                    </div>
                    <div class="col-md-8" style="margin-top: 20px;">
                        <div>
                            <a class='blue' href="<?=WEBDIR?>user?module=<?=$c[0]->getAttr('id');?>"><?=$c[0]->printName();?></a>
                        </div>
                        <div style="position: absolute;top: -8px;left: 120px;">
                            <?= user::printNoteUserMin($c[0]->user_notation);?>
                        </div>
                        <div>
                            <?php echo product::getNumberProducts($c[0]->getAttr('id'));?> objets
                        </div>
                        <div>
                            <?php echo contact::countMyContact(); ?> amis en commun
                        </div>
                        <div>
                            <img src="<?=WEBDIR?>img/contact/ville.png" alt=""/>&nbsp;<?php echo user::getCity($c[0]->getAttr('address'));  ?>
                        </div>
                    </div>
                    <div class="col-md-6 button" style="padding: 0;">
                        <form action='inbox' method='GET'>
                            <input name='module' type='hidden' value='<?=$c[0]->getAttr('id');?>' />
                            <button type='submit' class="sendmsg">message</button>
                        </form>
                        <form action='' method='GET'>
                            <input name='delete_friend' type='hidden' value='<?=$c[0]->getAttr('id');?>' />
                            <button type="submit" class="send">supprimer</button>
                        </form>
                    </div>
                </div>

<?php
            }
        }
    } else {
?>
        <div style='margin-left:5px;'>
            vous n'avez pas de contact.
        </div>
<?php
    }
?>