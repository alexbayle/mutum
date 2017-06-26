<div class="row2">
    <div class="col-md-18 title">
        <h1>liste de souhaits</h1>
    </div>
    <div class="col-md-18 wishlist" style="padding: 0;">
        <div class="col-md-18 search_wish">
            <form action="" method="post">
                <h2>ma demande</h2>

                <div class="col-md-5 item">
                    <input type="text" name="nom" id='Objname' placeholder="nom de l'objet"/>

                    <select id="cat1" class="chain-select" data-child="#cat2" data-submit="false" name="cat1">
                        <?php foreach ($catList as $cat) : ?>
                            <option value="<?php echo $cat['cata_id'] ?>"><?php echo $cat['cata_name'] ?></option>
                        <?php endforeach ?>
                    </select>

                    <div style="display:none;">
                        <select id="cat2" class="chain-select" data-child="#cat3" data-submit="false" name="cat2"></select>
                    </div>
                    <div style="display:none;">
                        <select id="cat3" class="chain-select" data-submit="false" name="cat3"></select>
                    </div>
                </div>

                <div class="col-md-8 item">
                    <textarea name="desc" id="desc" placeholder="description" cols="60" rows="5"></textarea>
                </div>
                <div class="col-md-5 item">
                    <input type="date" name="wish_date" id='date' value='<?= @$date ?>' style="float: right;"/>

                    <input type="text" name="adresse" id='addr' value='<?= @$addr ?>' placeholder="adresse" style="float: right;"/>
                    <div id="findMe">
                        <img src='<?=WEBDIR?>img/localisation.png' style='cursor:pointer;position:absolute;top: 49px;right: 12px;'>
                    </div>
                    <br />
                    <input type="submit" value="Ok" name='newWish'>
                </div>
            </form>
        </div>

        <div id="map"></div>

        <div class="col-md-18 lesdemandes">
            <div class="col-md-6">
                <h2>les demandes (recherche avancée)</h2>
                <hr>
                <form id="advanced_search_form" action="" method="post">
                    <div class="demande_item">
                        <label for="nom">nom :</label>
                        <input type="text" name="nom" class="nom" placeholder="nom..."/>
                    </div>
                    <div class="demande_item">
                        <label for="adresse">adresse :</label>
                        <input type="text" class="myAddress" id="myAddress" name="myAddress" placeholder="adresse..." value="<?= @$addr ?>"/>
                        <div id="findMe">
                            <img src='<?=WEBDIR?>img/localisation.png' style='cursor:pointer;position:absolute;top: 107px;right: 27px;'>
                        </div>
                    </div>
                    <div class="demande_item">
                        <label for="category1">catégorie :</label>
                        <select id="category1" class="chain-select" data-child="#category2" name="category1">
                            <?php foreach ($catList as $cat) : ?>
                                <option value="<?php echo $cat['cata_id'] ?>"><?php echo $cat['cata_name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="demande_item" style="display:none;">
                        <label for="category2">sous-catégorie :</label>
                        <select id="category2" class="chain-select" data-child="#category3" name="category2"></select>
                    </div>
                    <div class="demande_item" style="display:none;">
                        <label for="category3">catégorie 3:</label>
                        <select id="category3" class="chain-select" name="category3"></select>
                    </div>
                    <div class="menu">
                        <ul>
                            <li>demandes de mes contacts
                                <input type="checkbox" name="check_demandecontact" id="check_demandecontact"/>
                                <label for="check_demandecontact" class="roundbox">
                                </li>
                            <!--<li>demandes ciblées
                                <input type="checkbox" name="check_demandecible" id="check_demandecible"/>
                                <label for="check_demandecible" class="roundbox">
                                </li>-->
                                <li>mes demandes
                                    <input type="checkbox" name="check_demande" id="check_demande"/>
                                    <label for="check_demande" class="roundbox">
                                    </li>
                                </ul>
                            </div>
                            <div class="search_submit">
                                <input type="submit" value="rechercher" name="btnsearchAsk">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <div id='listDemandes'>

                            <input style="display:none" value=<?php if(isset($_GET['p'])) echo $_GET['p']; else echo '1'; ?> id="cPage"/>


                        </div>
                <!--<div >
                    <input id="searchMore" type="button" value="Plus">
                </div> -->
                <div id="itemsPagination" style="margin-right: 20px;margin-bottom: 10px;">
                    
                </div>



            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){


    // Auto Complétion des addresse de la barre de recherche
    function initialize_menu() {
        var options_auto = { types: ['address'] };
        var input = document.getElementById('myAddress');
        var autocomplete = new google.maps.places.Autocomplete(input,options_auto);
    }
    google.maps.event.addDomListener(window, 'load', initialize_menu);
});

    function showPosition(position) {
        $.post("/js/ajax/localisation.php" ,{ localisation:position.coords.latitude+','+position.coords.longitude } ,function(data){
            $('#addr').val(data);
            $('#myAddress').val(data);
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



    $(function() {
    //    Initialise la zone des marqueurs
    var zoneMarqueurs = new google.maps.LatLngBounds(),
    latitude = '<?echo $latitude ?>',
    longitude = '<?echo $longitude ?>',
    offset = 0;

    //Ma Position
    var latlng = new google.maps.LatLng(latitude, longitude);

    //Affichage Carte
    var options_map = {
        center: latlng,
        navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
        mapTypeId: google.maps.MapTypeId.ROADWAY,
        zoom: 8
    };
    var map = new google.maps.Map(document.getElementById("map"), options_map);
    var markers = [];

    //Affichage marqueur ma position

    var myPosition = new google.maps.Marker({
        position: latlng,
        map: map,

        title: "Votre Adresse"
    });
    zoneMarqueurs.extend(myPosition.getPosition());


    function manageMapMarkers(data, reset) {
        if (reset != true) {
            $('#listDemandes').append(data.html);
        } else {
            resetMarkers();

            $('#listDemandes').html(data.html);
            offset = 0;
        }

        pagination();

        if (Array.isArray(data.pos)) {
            $.each(data.pos, function (k, pos) {
                var geoCode = new google.maps.LatLng(pos[0], pos[1]);
                var marker = new google.maps.Marker({
                    position: geoCode,
                    map: map,
                    title: pos[2],
                    content: pos[2]
                });

                var infowindow = new google.maps.InfoWindow();
                google.maps.event.addListener(marker, 'click', function () {
                    infowindow.setContent(this.content);
                    infowindow.open(map, this);
                });

                markers.push(marker);
                zoneMarqueurs.extend(geoCode);
            });

            offset += 5;

            map.fitBounds(zoneMarqueurs);


            addHandler();
        }
    }

    function affichWishs() {

        var params = $('#advanced_search_form').serializeArray();
 /****
    // Je sais pas à quoi ça servait mais ca faisait tout planter
        $.each(params, function (i, param) {
            if (param !== undefined) {
                params[param.name] = param.value;
//                params.splice(i);
}
});
        params.lat = latitude;
        params.lng = longitude;
        params.offset = offset;

        params = $.extend({}, params);*/
        $.ajax({
            url: "<?=AJAXLOAD?>affichewishs",
            data: params, //{'offset': offset, 'lat': latitude, 'lng': longitude},
            dataType: 'json',
            type: 'POST',
            success: function (data) {
                manageMapMarkers(data);
            }
        });

    }

    function addHandler() {
        $('.btnI').on('click', function (e) {
            e.preventDefault();
            var named = $(this).parent().parent().find('.product_name').text();
            $('#Objname').attr('value', named);
            var address = "<?echo Session::Myloc()->getAddress(); ?>";
            $('#addr').val(address);

            $(window).scrollTo(document.getElementById('Objname').offsetTop);
        });


        $('.btnGot').on('click', function (e) {
            e.preventDefault();

            var wishId = $(this).data('id');
            window.location.href = "<?php echo WEBDIR ?>new/wish/" + wishId;
        });
    }


    $('#searchMore').on('click', function (e) {
        e.preventDefault();
        affichWishs();

    });

    $('.chain-select').on('change', function(e) {
        e.preventDefault();

        var me = this,
        child = $(this).data('child');

        $.ajax({
            url: "<?php echo AJAXLOAD ?>category",
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

                    if ($(me).data('submit') != false) {
                        $(me.closest('form')).submit();
                    }

                } else {
                    console.log('erreur');
                }
            }
        });
});


$('#advanced_search_form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: "<?=AJAXLOAD?>affichewishs",
        data: $(this).serialize(),
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            if (data.searchPos) {
                latitude = data.searchPos.lat;
                longitude = data.searchPos.lng;
            }
            manageMapMarkers(data, true);
        }
    })

});

function resetMarkers()
{
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers = [];
}

affichWishs();

function pagination(){
    var nbWishs = $('.listwish').length; 

    if(nbWishs>5){
        var nbPages = Math.ceil(nbWishs/5);
        var cPage = $('#cPage').val();
        //if(!(cPage>0 && cPage<=nbPages)) cPage=1;
        if(cPage > 3 && nbPages > 5)
            $('#itemsPagination').append("<a class='numPage' href='?p="+1+"'>Début </a>");
        var skip = 0;
        var nb_aff = 0;
        for (var i = 1; i <= nbPages; i++) {
            if((i >= cPage - 2 && i <= cPage + 2) || nbPages <= 5){
                skip = 0;
                $('#itemsPagination').append("<a class='numPage' href='?p="+i+"'>"+i+" </a>");
            }   
            else{
                if(skip == 0){
                    skip = 1;
                    $('#itemsPagination').append("... ");
                }
            }
        }
        if(cPage < nbPages - 2 && nbPages > 5)
            $('#itemsPagination').append("<a class='numPage' href='?p="+nbPages+"'>Fin </a>");


        //on met la couleur sur cPage
        $('.numPage').each(function(){
            if($(this).html()=='Début ' && cPage==1 ) $(this).addClass('blue');
            if($(this).html()=='Fin ' && cPage==nbPages ) $(this).addClass('blue');
            if(parseInt($(this).html())==parseInt(cPage)) $(this).addClass('blue');
        })

        $('.listwish').each(function(index){
            if(index<cPage*5-5 || index >= cPage*5) $(this).attr('style','display:none');
        })
        
    }
}

});
</script>