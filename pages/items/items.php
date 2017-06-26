<div class="row2">
    <div class="col-md-18 title">
        <h1>mes objets</h1>
    </div>

    <div class='col-md-3 itemsMenu'>
        <form action="" method="GET">
            <div id='itemsMenuCategories'>
                <div class='itemsMenuCategory'>
                    <div class='color_0 itemsMenuCategoryTitle' id='itemsMenuCategoryTitle_1'>
                        <span class='itemsMenuCategoryName color_1' id='itemsMenuCategoryName_1'>
                            objets en prêt
                        </span>
                        <span>
                            <input checked id='itemsMenuCheck_0' type='checkbox' />
                            <label class='checkCategory selected' for='itemsMenuCheck_0' id='itemsMenuCheckbox_0'></label>
                        </span>
                    </div>
                    <div class='blue itemsMenuCategoryContent' id='itemsMenuCategoryContent_1'>
                        <span class='bold nbItems'><?=$number_art_unavailable?></span> / <?=$number_art_search?>
                    </div>
                </div>
                <div class='itemsMenuCategory'>
                    <div class='color_0 itemsMenuCategoryTitle' id='itemsMenuCategoryTitle_2'>
                        <span class='itemsMenuCategoryName color_2' id='itemsMenuCategoryName_2'>
                            objets disponibles
                        </span>
                        <span>
                            <input checked id='itemsMenuCheck_1' type='checkbox' />
                            <label class='checkCategory selected' for='itemsMenuCheck_1' id='itemsMenuCheckbox_1'></label>
                        </span>
                    </div>
                    <div class='blue itemsMenuCategoryContent' id='itemsMenuCategoryContent_2'>
                        <span class='bold nbItems'><?=$number_art_available?></span> / <?=$number_art_search?>
                    </div>
                </div>
                <!--<div class='itemsMenuCategory'>
                    <div class='color_0 itemsMenuCategoryTitle' id='itemsMenuCategoryTitle_3'>
                        <span class='itemsMenuCategoryName color_3' id='itemsMenuCategoryName_3'>
                            ?
                        </span>
                        <span>
                            <input checked id='itemsMenuCheck_3' type='checkbox' />
                            <label class='checkCategory selected' for='itemsMenuCheck_3' id='itemsMenuCheckbox_3'></label>
                        </span>
                    </div>
                    <div class='blue itemsMenuCategoryContent' id='itemsMenuCategoryContent_3'>
                        content ...
                    </div>
                </div>-->
                <!--<div class='itemsMenuCategory'>
                    <div class='color_0 itemsMenuCategoryTitle' id='itemsMenuCategoryTitle_4'>
                        <span class='itemsMenuCategoryName color_4' id='itemsMenuCategoryName_4'>
                            ?
                        </span>
                        <span>
                            <input checked id='itemsMenuCheck_4' type='checkbox' />
                            <label class='checkCategory selected' for='itemsMenuCheck_4' id='itemsMenuCheckbox_4'></label>
                        </span>
                    </div>
                    <div class='blue itemsMenuCategoryContent' id='itemsMenuCategoryContent_4'>
                        content ...
                    </div>
                </div>-->
            </div>
                <div>
                    <label for="searchMyItems"></label>
                    <input type='search' id='searchMyItems' value="<?php echo $search_product;?>" name="search_product" placeholder="rechercher..." />
                </div>
                <div class="loupe" style="height: 0px">
                    <button type='submit' style="padding: 0;border: 0;"><img src="<?php WEBDIR ?>img/contact/loupe.png" alt="" style="position: absolute; top: 238px;left:143px;cursor: pointer;"/></button>
                </div>
        </form>
    </div>
    <div class='col-md-15 itemsList' id='itemsList' style="width: 81.3333333%;margin-left: 20px;min-height: 266px;;">
        <div class='col-md-18' style="padding: 0">
            <?php
            $cptSearch = 0 ;
            $tab_marker = array() ;
            foreach($tab_art_search as $a) {
                ?>
                <div class='col-md-18 itemsListArticle itemsListArticleCategory_<?=$a[1]->getAttr('dispo')?> surligneur' data-surligneur='<?=$cptSearch?>' style='padding-left:0px;'>
                    <div class='itemsListArticlePicture'>
                        <a href="<?=WEBDIR?>view?module=<?=$a[0]->getAttr('id')?>"><?=$a[1]->print_picture(140, 'round')?></a>
                    </div>
                    <div class='itemsListArticleInfos'>
                        <span class='itemsListArticleInfosName'><a href="<?=WEBDIR?>view?module=<?=$a[0]->getAttr('id')?>" style="color:#00a2b0;"><?=$a[0]->getAttr('name')?></a></span>
                        <?=$a[1]->getNoteMoy($a[1]->getAttr('id'))?> (<?=$a[0]->getNbNotation($a[1]->getAttr('id'))?>)
                        <br /><br />
                        catégorie : <span class='blue' id='itemsListArticleInfosOther'><?=$a[1]->getCatName()?></span>
                        &nbsp;&nbsp;/&nbsp;&nbsp;
                        caution : <span class='blue' id='itemsListArticleInfosOther'><?=$a[1]->getAttr('caution')?> €</span>
                        <br /><br />
                        description :<div id='itemsListArticleInfosOther'><?=$a[1]->getAttr('desc')?></div>
                    </div>
                    <div id='itemsListArticleMutumday'>
                        <div class="col-md-18" style="padding: 0;">
                            <form method='post' action="">
                                <input type="hidden" value="<?= $a[1]->getAttr('id') ?>" name="article_id"/>
                                <input type='submit' name='btn_edit' class="edit" value='éditer'>
                            </form>
                        </div>
                        <div class="col-md-18" style="padding: 0;margin-top: 72px;">
                            <?=$a[1]->getMutumByDay()?> <img alt='mutumByDay' src='<?=WEBDIR?>/img/search_mutum_day.png' style='width:30px;'> / jour
                        </div>
                    </div>
                </div>
                <?php
                array_push($tab_marker,array($a[1]->getAttr('name'))) ;
                $cptSearch++ ;
            }
            ?>
            <div id='itemsPagination'>

            </div>
        </div>
    </div>
    <div class="col-md-15" id="searchResult">
            <?php include(Site::include_view('searchProduct')) ?>
    </div>
</div>
<script type='text/javascript'>
    $(document).ready(function() {

        function hideAll(){
            $('#itemsList').hide() ;
            $('#searchResult').hide() ;
        }

        var searchResult = $("#searchMyItems").val();
        console.log(searchResult);
        if(searchResult == '') {
            hideAll();
            $('#itemsList').show();
        } else {
            hideAll();
            $('#searchResult').show();

        }

        function initMenu() {
            $('#itemsMenuCategoryContent_1').hide() ;
            $('#itemsMenuCategoryContent_2').hide() ;
            $('#itemsMenuCategoryContent_3').hide() ;
            $('#itemsMenuCategoryContent_4').hide() ;
        }
        function itemsPagination(nb) {
            paginationContent = '' ;
            maxPage = Math.ceil(nb / <?php echo $NB_ART_PAGE ?>) ;
            p = <?php echo $p ?> ;
            if(maxPage > 1) {
                if(p > 3 && maxPage > 5) {
                    paginationContent += "<a href='?s_a_cat=<?=$s_a_cat?>&s_a_name=<?=$s_a_name?>&s_a_loc=<?=$url_address?>&p=1'>début</a>" ;
                }
                skip = 0 ;
                for(i = 1; i <= maxPage; i++) {
                    if((i >= p-2 && i<= p+2) || maxPage <= 5) {
                        skip = 0 ;
                        if(i === p) {
                            style = "color:#00a2b0" ;
                        } else {
                            style = "" ;
                        }
                        paginationContent += "<a href='?s_a_cat=<?=$s_a_cat?>&s_a_name=<?=$s_a_name?>&s_a_loc=<?=$url_address?>&p=" + i + "' style='" + style +"'> " + i + " </a>" ;
                    } else {
                        if(skip === 0) {
                            skip = 1 ;
                            paginationContent += ' ... ' ;
                        }
                    }
                }
                if(p < maxPage-2 && maxPage > 5) {
                    paginationContent += "<a href='?s_a_cat=<?=$s_a_cat?>&s_a_name=<?=$s_a_name?>&s_a_loc=<?=$url_address?>&p=" + maxPage + "'>fin</a>" ;
                }
            }
            $('#itemsPagination').html(paginationContent) ;
        }

        nbArticles = <?php echo $number_art_search ?> ;
        console.log(nbArticles);
        initMenu() ;
        itemsPagination(nbArticles) ;

        // Click sur un nom de catégorie
        $('.itemsMenuCategoryName').click(function() {
            // Récupération de l'ID de la catégorie cliquée
            id = parseInt($(this).prop('id').replace('itemsMenuCategoryName_', '')) ;

            // MENU: estion des couleurs/affichages
            if($('#itemsMenuCategoryTitle_' + id).hasClass('color_0')) {
                $('#itemsMenuCategoryTitle_' + id).removeClass('color_0') ;
                $('#itemsMenuCategoryTitle_' + id).addClass('color_' + id) ;
                $('#itemsMenuCategoryContent_' + id).show() ;
                for(j = 1; j <= 4; j++) {
                    if(!$('#itemsMenuCategoryTitle_' + j).hasClass('color_0') && j !== id) {
                        $('#itemsMenuCategoryTitle_' + j).removeClass('color_' + j) ;
                        $('#itemsMenuCategoryTitle_' + j).addClass('color_0') ;
                        $('#itemsMenuCategoryContent_' + j).hide() ;
                    }
                }
            } else {
                $('#itemsMenuCategoryTitle_' + id).removeClass('color_' + id) ;
                $('#itemsMenuCategoryTitle_' + id).addClass('color_0') ;
                $('#itemsMenuCategoryContent_' + id).hide() ;
            }
        }) ;

        // Click sur une checkbox
        $('.checkCategory').click(function() {
            // Récupération de l'ID de la checkbox cliquée
            id = parseInt($(this).prop('id').replace('itemsMenuCheckbox_', '')) ;
            console.log(id);
            // Affichage des articles des catégories choisies
            if(!$('#itemsMenuCheckbox_' + id).hasClass('selected')) {
                $('#itemsMenuCheckbox_' + id).addClass('selected') ;
                $('.itemsListArticleCategory_' + id).show() ;
                if(id == 0) {
                    nbArticles += <?php echo $number_art_unavailable ?> ;
                }
                if(id == 1) {
                    nbArticles += <?php echo $number_art_available ?> ;
                }
            } else {
                $('#itemsMenuCheckbox_' + id).removeClass('selected') ;
                $('.itemsListArticleCategory_' + id).hide() ;
                if(id == 0) {
                    nbArticles -= <?php echo $number_art_unavailable ?> ;
                }else
                if(id == 1) {
                    nbArticles -= <?php echo $number_art_available ?> ;
                }
            }
            itemsPagination(nbArticles) ;
        }) ;

        // Click sur la div d'un objet
        $('.itemsListArticle').click(function() {
            $(this).toggleClass('itemSelected') ;
        }) ;


    });



</script>