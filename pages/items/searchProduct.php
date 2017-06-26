
    <?php
        $f = 0 ;
        if($results != array()) {
            foreach($results as $r) {
                if($r[0]->getAttr('id') != Session::Me()->getAttr('id')) {
    ?>
    <div class='col-md-18 itemsListArticle itemsListArticleCategory_<?=$r[1]->getAttr('state')?> surligneur' data-surligneur='<?=$cptSearch?>' style='padding-left:0px;'>
        <div class='itemsListArticlePicture'>
            <?=$r[1]->print_picture(140, 'round')?>
        </div>
        <div class='itemsListArticleInfos'>
            <span class='itemsListArticleInfosName'><?=$r[0]->getAttr('name')?></span>
            <?=$r[1]->getNoteMoy($r[1]->getAttr('id'))?> (<?=$r[0]->getNbNotation($r[1]->getAttr('id'))?>)
            <br /><br />
            catégorie : <span class='blue' id='itemsListArticleInfosOther'><?=$r[1]->getCatName()?></span>
            &nbsp;&nbsp;/&nbsp;&nbsp;
            caution : <span class='blue' id='itemsListArticleInfosOther'><?=$r[1]->getAttr('caution')?> €</span>
            <br /><br />
            description :<div id='itemsListArticleInfosOther'><?=$r[1]->getAttr('desc')?></div>
        </div>
        <div id='itemsListArticleMutumday'>
            <div class="col-md-18" style="padding: 0;">
                <form method='post' action="">
                    <input type="hidden" value="<?= $r[1]->getAttr('id') ?>" name="article_id"/>
                    <input type='submit' name='btn_edit' class="edit" value='edit'>
                </form>
            </div>
            <div class="col-md-18" style="padding: 0;margin-top: 83px;">
                <?=$r[1]->getMutumByDay()?> <img alt='mutumByDay' src='<?=WEBDIR?>/img/search_mutum_day.png' style='width:30px;'> / jour
            </div>
        </div>
    </div>
    <?php
    array_push($tab_marker,array($r[1]->getAttr('name'))) ;
    $cptSearch++ ;
    ?>


<?php
        $f = 1 ;
        }
    }
}
if($f == 0) {
    ?>
    <div style='margin-left:5px;'>
        La recherche n'a renvoyé aucun résultat.
    </div>
<?php } ?>