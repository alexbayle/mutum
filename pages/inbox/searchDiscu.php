<?php
    $f = 0 ;
    if($results != array()) {
        $i=0;
            foreach ($results as $d) {
                //var_dump($d);
?>
                <div class='col-md-18 nameDiscussionMenu discussMenu_<?php echo $i; ?> ' id="<?=$d[0]->getAttr('id')?> " style='padding: 0;'>
                    <div class="col-md-6" style="padding-left: 5px;padding-top: 10px;">
                        <?php echo $d[3]->print_user(80,'radius5'); ?>
                    </div>
                    <div class="col-md-11" style="padding: 0;color: #616161;padding-top: 10px;">
                        <div class="col-md-18" style="padding: 0;font-family: bariolBold">
                            <?php echo $d[3]->printName(); ?> -
                        </div>
                        <div class="col-md-18" style="padding: 0;">

                        </div>
                        <hr>
                        <div class="col-md-18" style="padding: 0;">
                            <span style="font-size: 15px"><?=$d[0]->getAttr('name')?></span><br />
                            <p style="font-size: 12px;  height: 23px;overflow: hidden; text-overflow: ellipsis;display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?php echo message::getMessageById($d[0]->getAttr('id'))[0][0]->getAttr('text'); ?></p>
                        </div>
                    </div>
                </div>
                <?php $i++; ?>
<?php
        $f = 1 ;
    }
}

if($f == 0) {
    ?>
    <div style='margin-left:5px;'>
        La recherche n'a renvoyé aucun résultat.
    </div>
<?php } ?>