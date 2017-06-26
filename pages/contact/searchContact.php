<?php
    $f = 0 ;
    if($results != array()) {
        foreach($results as $r) {
            if($r[0]->getAttr('id') != Session::Me()->getAttr('id')) {
?>
                <div class='col-md-9 recherche <?=user::getCity($r[0]->getAttr('address'));?>' style="width: 385px;margin-left: 10px;margin-right: 10px;">
                    <div class="col-md-4" style="margin-top: 8px;padding: 0;">
                        <?=$r[0]->print_user(90,'profile');?>
                    </div>
                    <div class="col-md-8" style="margin-top: 20px;">
                        <div>
                            <a class='blue' href="<?=WEBDIR?>user?module=<?=$r[0]->getAttr('id');?>"><?=$r[0]->printName();?></a>
                        </div>
                        <div style="position: absolute;top: -8px;left: 120px;">
                            <?=user::printNoteUserMin($r[0]->user_notation);?>
                        </div>
                        <div>
                            <?=product::getNumberProducts($r[0]->getAttr('id'));?> objets
                        </div>
                        <div>
                            <?php echo contact::countMyContact(); ?> amis en commun
                        </div>
                        <div>
                            <img src="<?=WEBDIR?>img/contact/ville.png" alt=""/>&nbsp;<?php echo user::getCity($r[0]->getAttr('address'));  ?>
                        </div>
                    </div>
                    <div class="col-md-6 button" style="padding: 0;">
                        <form action='inbox' method='GET'>
                            <input name='module' type='hidden' value='<?=$r[0]->getAttr('id');?>' />
                            <button type='submit' class="sendmsg">message</button>
                        </form>
                            <?php if(contact::isContact($r[0]->getAttr('id'))) { ?>
                                <form action='' method='GET'>
                                    <input name='delete_friend' type='hidden' value='<?=$r[0]->getAttr('id');?>' />
                                    <button type="submit" class="send">supprimer</button>
                                </form>
                            <?php } else { ?>
                                <form action='' method='GET'>
                                    <input name='ask_friend' type='hidden' value='<?=$r[0]->getAttr('id');?>' />
                                    <?php if(!contact::checkExistMyAsk($r[0]->getAttr('id'))) { ?>
                                        <button type="submit" class="ajout">ajouter</button>
                                    <?php } else { ?>
                                        <button type='button' class="envoyer">demande envoyée</button>
                                    <?php } ?>
                                </form>
                            <?php } ?>
                    </div>
                </div>

<?php
                $f = 1 ;
            }
        }
?>
        <div id="itemsPagination" style="margin-right: 20px;margin-bottom: 10px;">
            <?php

            if($nbPage > 1){
                if($cPage > 3 && $nbPage > 5)
                {
                    echo "<a href='?search_user=$search_user&p=$i'>Debut </a>";
                }
                $skip = 0 ;
                $nb_aff = 0 ;
                for($i=1;$i<=$nbPage;$i++)
                {
                    if(($i >= $cPage - 2 && $i <= $cPage + 2) || $nbPage <= 5)
                    {
                        $skip = 0;
                        echo "<a href='?search_user=$search_user&p=$i'>".$i. "</a> ";
                    }
                    else
                    {
                        if($skip == 0)
                        {
                            $skip = 1 ;
                            echo " ... " ;
                        }
                    }
                }
                if($cPage < $nbPage - 2 && $nbPage > 5) {
                    echo "<a href='?search_user=$search_user&p=$i'>Fin</a>";
                }

            }

            ?>
        </div>
<?php
    }
    if($f == 0) {
?>
        <div style='margin-left:5px;'>
            oups, aucun résultat ne correspond à cette recherche !
        </div>
<?php } ?>