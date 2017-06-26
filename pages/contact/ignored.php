<?php
    if($ignored != array()) {
        foreach($ignored as $i) {
            if($i[0]->getAttr('id') != Session::Me()->getAttr('id')) {
?>
                <div class='col-md-9 unContact' style="width: 385px;margin-left: 10px;margin-right: 10px;">
                    <div class="col-md-4" style="margin-top: 8px;padding: 0;">
                        <?=$i[0]->print_user(80,'profile');?>
                    </div>
                    <div class="col-md-8" style="margin-top: 20px;">
                        <div>
                            <a class='blue' href="<?=WEBDIR?>user?module=<?=$i[0]->getAttr('id');?>"><?=$i[0]->printName();?></a>
                        </div>
                        <div style="position: absolute;top: -8px;left: 120px;">
                            <?=$i[0]->printNote();?>
                        </div>
                        <div>
                            <?=product::getNumberProducts($i[0]->getAttr('id'));?> objets
                        </div>
                        <div>
                            <?php echo contact::countMyContact(); ?> amis en commun
                        </div>
                        <div>
                            <img src="<?=WEBDIR?>img/contact/ville.png" alt=""/>&nbsp;<?php echo user::getCity($i[0]->getAttr('address'));  ?>
                        </div>
                    </div>
                    <div class="col-md-6 button" style="padding: 0;">
                            <form action='' method='GET'>
                                <input name='accept_friend' type='hidden' value='<?=$i[0]->getAttr('id');?>' />
                                <button type="submit" class="ajout">ajouter</button>
                            </form>
                            <form action='' method='GET'>
                                <input name='delete_ignored' type='hidden' value='<?=$i[0]->getAttr('id');?>' />
                                <button type='submit' class="send" >supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
    <?php
            }
        }
    } else {
?>
        <div style='margin-left:5px;'>
            vous n'avez ignoré personne.
        </div>
<?php
    }
?>


