<div class="row2">
    <div class="col-md-18 title">
        <h1>prêtez un objet</h1>
    </div>
    <div class="col-md-18 preter">
        <h2>informations :</h2>
        <form action="" method='POST'>
            <div class="col-md-9">
                <div>
                    <input type="hidden" name="arti_prod_id" value="<?php echo @$article->arti_prod_id ?>" />
                    <div class="demande_item">
                        <label for="name">nom de l'objet :</label>
                        <input type='text' name='art_name' id="art_name"  value='<?php echo @$article->prod_name ?>'>
                    </div>
                    <div class="demande_item">
                        <label for="state">état de l'objet :</label>
                        <select name='arti_state' id="state" class="chain-select">
                            <?php echo Site::combo_contents(article_state::getAll(), $article->arti_state, "arts_id", "arts_text"); ?>
                        </select>
                    </div>
                    <div class="demande_item">
                        <label for="durée">durée du prêt :</label>
                        <div class="new-info" style="display:inline;">
                            <img src="/img/info-icon.png" onMouseOut="this.src='/img/info-icon.png'" onMouseOver="this.src='/img/info-icon-hover.png'">
                                <span class="new-info">
                                    référencez une durée de prêt adaptée à votre objet. exemple : <br />- une paire de ski s'emprunte minimum une semaine<br />- un appareil à raclette s'emprunte minimum deux jours
                                </span>
                        </div>
                        <div style="float: right;">
                            <select name="arti_length" id="art_length" class="chain-select" style="">
                                <?php
                                for($i=2;$i<32;$i++){
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="demande_item">
                        <label for="prix">valeur d'achat :</label>
                        <div class="new-info1" style="display:inline;">
                            <img src="/img/info-icon.png" onMouseOut="this.src='/img/info-icon.png'" onMouseOver="this.src='/img/info-icon-hover.png'">
                                <span class="new-info">
                                     renseignez le prix d'achat de votre objet, neuf.
                                </span>
                        </div>
                        <div style="float: right;">
                            <input type='number' name='art_price' id="art_price" value='<?= @$article->arti_price ?>' style="  width: 116px;margin-right: 146px;">
                            <label style="position: absolute;right: 31px;top: 134px;"><span class="blueclair" id="mutum_amount"></span></label>
                        </div>
                    </div>
                    <div class="demande_item">
                        <label for="adresse">adresse de l'échange :</label>
                        <?php $i = 1; ?>
                        <!--    --><?php //if (@$full_address != '') : ?>
                        <!--        --><?php //foreach ($full_address as $t) : ?>
                        <!--            <input type='text' name='full_address_--><?php //echo $i ?><!--'-->
                        <!--                   value='--><?php //echo $t["addr_address"] ?><!-- --><?php //echo $t["addr_zip"] ?><!-- --><?php //echo $t["addr_city"] ?><!--'-->
                        <!--                   placeholder='adresse'>-->
                        <!--            <br/>-->
                        <!--            --><?php //$i++; ?>
                        <!--        --><?php //endforeach; ?>
                        <!--    --><?php //endif; ?>
                        <input type='text' name='full_address_<?= $i ?>' id='adresse' value="<?php echo @$article->art_address ?>" placeholder="">
                        <div id="findMe">
                            <img src='<?=WEBDIR?>img/localisation.png' style='cursor:pointer;position:absolute;top: 171px;right: 30px;'>
                        </div>
                    </div>
                    <div class="demande_item">
                        <label>photos :</label>
						<div class="new-info1" style="display:inline;">
                            <img src="/img/info-icon.png" onMouseOut="this.src='/img/info-icon.png'" onMouseOver="this.src='/img/info-icon-hover.png'">
                                <span class="new-info">
                                    formats acceptés : jpg, jpeg, png, gif
                                </span>
                        </div>
						<div>
							<span class="blueclair">&nbsp;un objet avec une photo est 7 fois plus consulté !</span><br />
						</div>
                    </div>
                    <div class="col-md-18 photos">
                        <div>
                            <div class="col-md-6 new_img" id="div_upload_1">
                                <span class="new_title_img"></span>
                                <div class="col-md-18" style="  padding: 0;  height: 110px;  " id="info_upload_1">
                                    <img class="new_img" id="img_upload_1" src="<?php echo WEBDIR . UPLOADDIR . '/art/' . @$article->arti_pictures[0] ? : '<span id="number_1" class="number">1</span>' ?>">
                                    <span id="number_1" class="number">1</span>
                                </div>
                                <span class="new_btn_upload" style="display:block;" name="" id="btn_upload_1">choisir le fichier</span>
                                <span style="display:none;" class="new_btn_delete" name="" id="del_upload_1">supprimer</span>
                                <input type="file" name="input_img_1" class="input_new_img well_transition" id="input_img_1" accept="image/bmp,image/gif,image/png,image/jpeg,image/x-ms-bmp">
                                <input type="hidden" name="image_1" id="image_1" value="" class="well_transition">
                            </div>
                            <div class="col-md-6 new_img" id="div_upload_2">
                                <span class="new_title_img"></span>
                                <div class="col-md-18" style="  padding: 0;  height: 110px;" id="info_upload_2">
                                    <img class="new_img" id="img_upload_2" src="<?php echo WEBDIR . UPLOADDIR . '/art/' . @$article->arti_pictures[1] ? : '<span id="number_2" class="number">2</span>' ?>">
                                    <span id="number_2" class="number">2</span>
                                </div>
                                <span class="new_btn_upload" style="display:block;" name="" id="btn_upload_2">choisir le fichier</span>
                                <span style="display:none;" class="new_btn_delete" name="" id="del_upload_2">supprimer</span>
                                <input type="file" name="input_img_2" class="input_new_img well_transition" id="input_img_2"
                                       accept="image/bmp,image/gif,image/png,image/jpeg,image/x-ms-bmp">
                                <input type="hidden" name="image_2" id="image_2" value="" class="well_transition">
                            </div>
                            <div class="col-md-6 new_img" id="div_upload_3">
                                <span class="new_title_img"></span>
                                <div class="col-md-18" style="  padding: 0;  height: 110px;" id="info_upload_3">
                                    <img class="new_img" id="img_upload_3" src="<?php echo WEBDIR . UPLOADDIR . '/art/' . @$article->arti_pictures[2] ? : '<span id="number_3" class="number">3</span>' ?>">
                                    <span id="number_3" class="number">3</span>
                                </div>
                                <span class="new_btn_upload" style="display:block;" name=""id="btn_upload_3">choisir le fichier</span>
                                <span style="display:none;" class="new_btn_delete" name="" id="del_upload_3">supprimer</span>
                                <input type="file" name="input_img_3" class="input_new_img well_transition" id="input_img_3"
                                       accept="image/bmp,image/gif,image/png,image/jpeg,image/x-ms-bmp">
                                <input type="hidden" name="image_3" id="image_3" value="" class="well_transition">
                            </div>
                            <input type="hidden" name="sess_id" id="sess_id" value="54f987a79d6b40812835094380163210"
                                   class="well_transition">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="demande_item">
                    <label for="category1">catégorie :</label>
                    <select id="category1" class="chain-select" data-child="#category2" name="art_cat_id1">
                        <?php echo Site::combo_contents(category_article::getMainList(), $article->art_cat, "cata_id", "cata_name"); ?>
                    </select>
                </div>
                <div class="demande_item" style="display:none;">
                    <label for="category2">sous-catégorie :</label>
                    <select id="category2" class="chain-select" data-child="#category3" name="art_cat_id2"></select>
                </div>
                <div class="demande_item" style="display:none;">
                    <label for="category3">catégorie 3 :</label>
                    <select id="category3" class="chain-select" name="art_cat_id3"></select>
                </div>
                <div class="demande_item">
                    <label for="description">description :</label>
                    <textarea name='art_desc' col="10" rows="5" id='description'><?= @$article->art_desc ?></textarea>
                    <br />
                    <span class="blueclair">récoltez plus de mutums </span><br />
                    <span class="blueclair">en détaillant davantage</span>
                </div>
                <div class="demande_item">
                    <label for="dispo" style="position: absolute;margin-top: 59px">indisponibilité :</label>
                    <input id="input-dates" type="hidden" name='art_dates' id="dispo" value='<?= @$article->arti_dates ?>'><br/>
                    <div id="calendar" class="col-md-10 calendar"></div>
                    <div class="disponible" style="margin-top: 86px">
                        <span class="blueclair">x</span><span class="blueclair" style="margin-left: 4px;">disponible</span><br />
                    </div>
                    <div class="indisponible">
                        <span class="roundorange">x</span><span class="orange" style="margin-left: 37px;">indisponible</span>
                    </div>
                </div>
            </div>
            <div class="col-md-18" style="padding: 0;">
                <div class="col-md-9" style="margin-top: 2%;margin-bottom: 5%">
                    <h2 style="margin-left: 7%;margin-top: 0px;">avancé :</h2>
                    <div class="col-md-9" style='position:relative;padding:10px 3px 0px 35px'>
                        <label for='chk_caution'>je souhaite une caution</label>
                        <input type='checkbox' id='chk_caution' name='btn_caution' value='1' onclick="hideThis('caution_range')">
                        <label for='chk_caution' class='box' style="left:192px;"></label>
                    </div>


                    <div class="col-md-9" style="">
                        <div id="caution_range" class="caution_range" style="display: none;">
                            <input type='number' id='art_caution' name='art_caution' value='<?= @$article->arti_caution ?>'> € (maximum : <span id="max_val_caution">0</span> €)
                        </div>
                    </div>
                    <div class="col-md-18 demande_item">
                        <?php if(community::getAllMyCommunity() != array()){ ?>
                        <select id="communities" name="communities" class="form-control multiple" multiple="multiple">
                            <?php foreach (community::getAllMyCommunity() as $community) : ?>
                                <option value="<?php echo $community[0]->getAttr('id') ?>"><?php echo $community[0]->getAttr('name') ?></option>
                                <!--<input name ="community_<?=$community[0]->getAttr('id')?>" type="checkbox" style="display: block;" value="<?php echo $community[0]->getAttr('id') ?>"><?php echo $community[0]->getAttr('name') ?></input>
                                <br />-->
                            <?php endforeach; ?>
                        </select>
                        <?php }else{ ?>
                        <?php }?>
                    </div>
                </div>

                <div class="col-md-9" style="  margin-top: 2%;margin-bottom: 5%">
                    <div class="mutum_gagner">
                        <div class="col-md-12">
                            <h2 class="orange">mutum(s) gagné(s) :</h2><br />
                            <span style="padding-left: 20px">félicitations, vous récoltez <span id="mutum_gagner">0</span> mutum(s) !</span>
                        </div>
                        <div class="col-md-6">
                            <span id="mutum_win" class="mutum_win">0</span>
                            <img src="<?= WEBDIR ?>/img/pile-money-02.png" alt="" style="margin-left: 20px;margin-top: -12px;"/>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4 col-md-offset-7 send">
                <?php if (!isset($_GET['module'])
                    || (isset($_GET['module']) && ($_GET['module'] == "" || $_GET['module'] == 'wish'))) : ?>
                    <input type='submit' name='btnnew' value='partager cet objet'>
                <?php else : ?>
                    <input type='submit' name='btnedit' value='modifier'>
                    <input type='submit' name='btndelete' value='supprimer'>
                    <?php if (@$btn_caution == 1) : ?>
                        <input type='number' name='art_caution' value=''><br/>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    //$('#ui-multiselect-communities-option-2').click(function(){ console.log($('#ui-multiselect-communities-option-2').attr('aria-selected'))});

    $(document).ready(function(){

        // Auto Complétion des addresse de la barre de recherche
        function initialize_menu() {
            var options_auto = { types: ['address'] };
            var input = document.getElementById('adresse');
            var autocomplete = new google.maps.places.Autocomplete(input,options_auto);
        }
        google.maps.event.addDomListener(window, 'load', initialize_menu);
    });

    function showPosition(position) {
        $.post("/js/ajax/localisation.php" ,{ localisation:position.coords.latitude+','+position.coords.longitude } ,function(data){
            $('#adresse').val(data);
            $.cookie('my_location',data,{ expires: 365 , path:'/'});
        });
    }

    function FindMe(){
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Ce navigateur ne supporte pas la géolocalisation");
        }
    }

    $('#findMe').click(FindMe);

    function hideThis(_id) {
        var obj = document.getElementById(_id);
        if (obj.style.display == "block")
            obj.style.display = "none";
        else
            obj.style.display = "block";
    }

    var tab_upload = [];
    tab_upload[0] = true;
    tab_upload[1] = true;
    tab_upload[2] = true;
    tab_upload[3] = true;
    $('.new_btn_delete').click(function () {
        var id = $(this).attr('id').replace('del_upload_', '');
        tab_upload[id - 1] = true;
        $.post("/js/ajax/loader.php?fonction=image&method=delete", {img: $('#image_' + id).val()}, function (data) {
        });
        $('#img_upload_' + id).attr('src', '');
        $('#info_upload' +id).children()
        $('#image_' + id).attr('value', '');
        $('#input_img_' + id).css('display', 'block');
        $('#btn_upload_' + id).css('display', 'block');
        $('#del_upload_' + id).css('display', 'none');
    });



    $('.input_new_img').change(function () {
        var id = $(this).attr('id').replace('input_img_', '');


        if (tab_upload[id - 1]) {
            tab_upload[id - 1] = false;
            $('#input_img_' + id).css('display', 'none');
            $('#img_upload_' + id).attr('src', '');
            $(this).parent().children().children().addClass('block1');
            $('#number_' + id).css('display','none');
            $('#btn_upload_' + id).css('display', 'none');
            var formData = new FormData();
            formData.append("id_session", '54f98ba87fec04078559204832191394');
            formData.append("id", id);
            formData.append('art', this.files[0]);
            var xhr = new XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var progress = Math.ceil((evt.loaded / evt.total) * 100);
                    $('#num_progress_' + id).html(progress + "%");
                    $('#progress_' + id).css('width', progress + '%');
                    if (progress == 100) {
                        $('#num_progress_' + id).html('traitement...');
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState == 4) {
                                if (xhr.responseText == 'error')
                                {
                                    $('#bar_' + id).hide();
                                    $('#input_img_' + id).css('display', 'block');
                                    $('#img_upload_' + id).attr('src', '/img/missing-grey.png');
                                    $('#btn_upload_' + id).css('display', 'block');
                                }
                                else
                                {
                                    var data = $.parseJSON(xhr.responseText);
                                    if (data.success)
                                    {
                                        $('#bar_' + id).hide();
                                        $('#img_upload_' + id).attr('src', data.webpath);
                                        $('#image_' + id).attr('value', data.filename);
                                        $('#del_upload_' + id).css('display', 'block');
                                        $('#input_img_' + id).val('');
                                        tab_upload[id - 1] = true;
                                    }
                                }

                                display_gagne();
                            }
                        }
                    }
                    else {
                        $('#bar_' + id).show();
                    }
                }
            }, false);
            xhr.open('POST', '<?php echo WEBDIR .  AJAXLOAD ?>image&method=upload', true);
            xhr.send(formData);
            return false;
        }
    });

    $('.chain-select').on('change', function(e) {
        e.preventDefault();

        var me = this,
            child = $(this).data('child');

        $.ajax({
            url: "/<?php echo AJAXLOAD ?>category",
            data: {method: 'getChildren', category_id: $(this).val()},
            dataType: 'json',
            type: 'POST',
            success: function(data) {
                if (data.success == true) {
                    $(child).html('');
                    if ($(child).data('child')) {
                        $($(child).data('child')).html('');
                    }

                    if (data.datas.length) {
                        $(child).append('<option value=""></option>');
                    }
                    $.each(data.datas, function (k, category) {
                        $(child).append('<option value="' + category.cata_id + '">' + category.cata_name + '</option')
                    });

                    $.each($('.chain-select'), function(k, v) {
                        if ($(v).html()) {
                            $(v).parent().show();
                        } else {
                            $(v).parent().hide();
                        }
                    });

                } else {
                    console.log('erreur');
                }
            }
        });
    });


    //    var dates = <?php //echo ($thisart_dates? : '[]'; ?>//;
    $('#calendar').multiDatesPicker({
        dateFormat: 'yy-mm-dd',
//            addDates: dates
//        addDisabledDates: $('#input-dates').val(),
        altField: '#input-dates',
        minDate: 'today'

    });


    mutum_name = 0;
    mutum_cat = 0;
    mutum_amount = 0;
    mutum_address = 0;
    mutum_state = 0;
    mutum_desc = 0;
    mutum_photo = 0;


    var range = $('#art_caution'),
    range_value = $('#range-value');

    $("#art_price").keyup(function(e){
        display_gagne();
        mutumWin();
    });
    $("#art_name").keyup(function(e){
        display_gagne();
    });
    $("#category1").change(function(e){
        display_gagne();
    });
    $("#adresse").blur(function(e){
        display_gagne();
    });
    $("#state").change(function(e){
        display_gagne();
    });
    $("#description").keyup(function(e){
        display_gagne();
    });
    $("#art_length").change(function(e){
        display_gagne();
    });
    $("#caution").change(function(e){
        if( parseInt($('#caution').attr("value")) > parseInt($("#prix").attr("value")) )
            $('#caution').attr("value",$("#prix").attr("value"));
        if(parseInt($('#caution').attr("value"))<0)
            $('#caution').attr("value",'0');
    });

    function display_gagne()
    {
        if ($("#art_price").val() !="")
        {
            mutum_amount = 1;
            $('#max_val_caution').html($('#art_price').val());
        }
        else
        {
            mutum_amount = 0;
        }


        if ($("#art_name").val()!="")
        {
            mutum_name = 1;
        }
        else
        {
            mutum_name = 0;
        }

        if ($("#category1").val() !="")
        {
            mutum_cat = 1;
        }
        else if ($("#category1").val() !="" && $('#category2').val() !="")
        {
            mutum_cat = 1;
        }
        else
        {
            mutum_cat = 0;
        }
        if ($("#adresse").val() !="")
        {
            mutum_address = 1;
        }
        else
        {
            mutum_address = 0;
        }
        if ($("#state").val() !="")
        {
            mutum_state = 1;
        }
        else
        {
            mutum_state = 0;
        }

        if($('#art_caution').val() > $('#art_price').val()){
            $('#art_caution').html($('#art_price').val());
        }else{

        }


        mutum_desc = Math.min(4,Math.floor((document.getElementById("description").value.split(/\b\w+\b/).length-1)/6));

        if($('#image_1').attr('value')!='' || $('#image_2').attr('value')!='' || $('#image_3').attr('value')!='')
        {
            mutum_photo = 3;
        }
        else
        {
            mutum_photo = 0;
        }
        mutum_gagner =
            parseInt(mutum_name)
                + parseInt(mutum_cat)
                + parseInt(mutum_amount)
                + parseInt(mutum_address)
                + parseInt(mutum_state)
                + parseInt(mutum_desc)
                + parseInt(mutum_photo)
        ;
        $("#mutum_gagner").html(mutum_gagner);
        $("#mutum_win").html(mutum_gagner);
    }

    function mutumWin()
    {
        var mutum_amount = $('#art_price').val();
        var art_length = document.getElementById('art_length').options[document.getElementById('art_length').selectedIndex].text;
        $("#mutum_amount").html(Math.ceil(mutum_amount / art_length )+ " mutum / jour ");
    }

/*
        $(function(){
            $("#communities").multiselect({
                noneSelectedText : "Choisissez des communautée(s)"
            });
        });

*/

    $("select.multiple").SumoSelect({
        placeholder: 'partagez uniquement avec :',
        captionFormat: '{0} séléctionnés',
        outputAsCSV:true
    });

</script>