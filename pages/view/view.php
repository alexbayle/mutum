<div class="row2">
    <div class="col-md-18 title">
        <h1><?php echo $prodName; ?></h1>
    </div>
    <div class="view">
        <div class="col-md-18 objet" style="height: auto;min-height: 350px;">
            <div class="col-md-4 img">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <?php echo $art->print_picture(220,'radius10','',0);?>
                    </div>
                </div>
            </div>
            <div class="col-md-8" style="margin-top: 20px;padding-left: 40px;">
                <div class="panel panel-default">
                    <div class="nom_produit">
                        <?php echo $prodName; ?>
                        <?php echo article::getNoteMoy($prodID); ?>
                    </div>
                    <div class="col-md-18" style="padding: 4px 0px;">
                        <div class="col-md-4">
                            <div class="titre_produit">
                                catégorie :
                            </div>
                        </div>
                        <div class="col-md-14">
                            <div class="texte_produit" style="color: #00a2b0;">
                                <?php echo $article[0][4]->getAttr('name'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-18" style="margin-top: 16px;height: auto;min-height: 90px;padding: 0;text-align: justify;">
                    <div class="col-md-9">
                        <div class="titre_produit">
                            description :
                        </div>
                    </div>
                    <div class="col-md-18">
                        <div class="texte_produit">
                            <p style="font-size: 15px;"><?php echo $prodDesc; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-18" style="padding: 4px 0px;">
                    <div class="col-md-3">
                        <div class="titre_produit">
                            caution :
                        </div>
                    </div>
                    <div class="col-md-4" style="padding-left: 7px;">
                        <div class="texte_produit">
                            <?php echo $article[0][1]->getAttr('caution')." "; ?>€
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="margin-top: 20px;">
                <div class="col-md-12" style="padding: 10px 0px; font-size: 25px;">
                    <div style="float: right;font-family: bariolbold;color: #515151;">
                    <?php echo user::printNote($prodOwner['user_nb_notation'],round($prodOwner['user_notation']))." ".$prodOwnerName; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class='owner'>
                        <div class="avatar"><?php echo $article[0][2]->print_user(80) ?></div>
                    </div>
                </div>
                <div class="col-md-12" style="padding: 0px 0px;">
                    <div class="owner_texte">
                        <span class="titre_produit">inscrit(e) le : </span><span class="blue"><?php user::getFormatDate($article[0][2]->getAttr('date_creation'));?></span>
                    </div>
                </div>

                <div class="col-md-12" style="padding: 0px 0px;">
                    <div class="owner_texte">
                         <span class="titre_produit">ville : </span><span class="blue"><?php echo $article[0][3]->getAttr('city'); ?></span>
                    </div>
                </div>

                <div class="col-md-12" style="padding: 0px 0px;">
                    <div class="owner_texte">
                         <span class="titre_produit">distance : </span><span class="blue"> <?php echo $prodAndOwnerDistance; ?></span>
                    </div>
                </div>
                <div class="col-md-14" style="margin-top: 30px;">
                    <span style="font-size: 18px;font-family: bariolbold;width: 100px; color: #515151;margin-left: 34px;">indisponibilité</span>
                    <div class="disponible" style="margin-top: 5px;">
                        <span class="blueclair" style="margin-left: 35px">x</span><span class="blueclair" style="margin-left: 7px;">disponible</span>
                        <span class="roundorange">x</span><span class="orange"  style="left: 223px;position: absolute;">indisponible</span>
                    </div>
                </div>
                <div class="col-md-14" style="padding: 0px 0px; z-index: 2;   position: absolute;  top: 185px;  left: 55px;" id="calendar"></div>
            </div>
            <div class="col-md-18" style="margin-top: 10px;">
                <?php if (\Session::Online()) : ?>
                    <?php if ($art->getAttr('user_id') !== \Session::Me()->user_id) : ?>
                        <div class="col-md-4" style="padding: 0;">
                            <button id="text" class="btn_loan">j'emprunte !</button>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="col-md-5" style="padding: 0;height: 50px;padding-left: 43px">
                    <div class="col-md-18" style="padding: 0;">
                        <div style="font-size: 25px;color: #515151;font-family: bariolbold;">
                            <div class="col-md-3" style="padding: 0;padding-top: 2px;width: auto;min-width: 10px;">
                                <?php echo $article[0][1]->getMutumByDay(); ?>
                            </div>
                            <div class="col-md-3" style="padding: 0;">
                                <img src="<?php echo WEBDIR; ?>/img/wallet/piecejaune.png" style="float: right;">
                            </div>
                            <div class="col-md-8" style="padding: 0;padding-top: 2px;">
                                / jour
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row2">
    <div class="col-md-18" style="z-index: 1;padding: 0;margin-bottom: 30px;">
        <div id="mapToDisplay">
            <div class="panel panel-default">
                <div class='col-md-18' id='google_map_results'>
                </div>
            </div>
        </div>

        <div id="formToDisplay">
            <div class="panel panel-default">
                <form id="contactForm" method="post" >
                    <div class="col-md-5">

                    </div>
                    <img src="<?=WEBDIR?>/img/mutum_rouge.png" class="mutum_rouge" alt=""/>
                    <div class="col-md-4">
                        <h1 style="width: 230px;margin-top: 30px;">empruntez cet objet !</h1>
                        <div class="col-md-18">
                            <div class="texte_produit" style="padding-top: 8px;">
                                date de début d'emprunt
                            </div>
                        </div>
                        <div class="col-md-18">
                            <div class="texte_produit" style="padding-top: 14px;">
                                date de fin d'emprunt
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="texte_produit" style="padding-top: 20px;">
                                message
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="col-md-18">
                            <input type="text" id="debutDate" name="requ_date_from" class="input_emprunt dateSelect" style="margin-top: 65px">
                        </div>
                        <div class="col-md-18">
                            <input type="text" id="finDate" name="requ_date_to" class="input_emprunt dateSelect">
                        </div>
                        <div class="col-md-18 comment_emprunt">
                            <textarea rows="8" cols="60" draggable="true" id="content" name="requ_message" class="textarea_emprunt" style="margin-top: 20px;"></textarea>
                            <br />
                                <?php  if ($article[0][1]->getAttr('caution') > "0") { ?>
                                    <?php foreach($cards as $c){ ?>
                                        <?php if($c->Active){ ?>
                                            <select name="card_number" id="card_number">
                                                <option value=""><?php echo $c->Alias ?></option>
                                            </select>
                                            <input type="hidden" value="<?php echo $c->Id ?>" name="card_id"/>
                                        <?php } ?>
                                    <?php } ?>
                                    <p>ce prêteur demande une caution. celle-ci ne sera débitée
                                        qu'en cas de souci et uniquement après avoir obtenu votre accord.
                                        <strong><a href="<?=WEBDIR?>settings/new_card" target="_blank">enregistrer une carte.</a></strong>
                                    </p>
                                <?php } ?>




                                <p><span class="texte_produit">total :</span>
                                    <span class="orange" style="font-size: 25px;"></span>
                                    <input type="hidden" value="0" name="prixTotalMutum" id="totalMutum"/>
                                    <img
                                        src="<?php echo WEBDIR; ?>/img/wallet/piecejaune.png"
                                        style="width: 30px; height: 21px;">
                                    <input id="maps" name="btnrequest" class="btn_loan" type="submit" value="j'emprunte !" style="margin-left: 115px"/>
                                </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">




    function dateDiff(date1, date2){
        var diff = {}                           // Initialisation du retour
        var tmp = date2 - date1;

        tmp = Math.floor(tmp/1000);             // Nombre de secondes entre les 2 dates
        diff.sec = tmp % 60;                    // Extraction du nombre de secondes

        tmp = Math.floor((tmp-diff.sec)/60);    // Nombre de minutes (partie entière)
        diff.min = tmp % 60;                    // Extraction du nombre de minutes

        tmp = Math.floor((tmp-diff.min)/60);    // Nombre d'heures (entières)
        diff.hour = tmp % 24;                   // Extraction du nombre d'heures

        tmp = Math.floor((tmp-diff.hour)/24);   // Nombre de jours restants
        diff.day = tmp;

        return diff;
    }



    //Function for hiding or showing the map
	$(document).ready(function(){

        $('.dateSelect').change(function(){

            var dateDebut =  new Date($('#debutDate').val());
            var dateFin = new Date($('#finDate').val());
            var diff = dateDiff(dateDebut, dateFin);
            $('.orange').html(diff.day* <?php echo $article[0][1]->getMutumByDay();?>);
            $('#totalMutum').val(diff.day* <?php echo $article[0][1]->getMutumByDay();?>);

        });




		//var date = new Date();
		
		$("#mapToDisplay").show();
		$("#formToDisplay").hide();
		$("#text").click(function(){
	        $("#mapToDisplay").toggle();
	        $("#formToDisplay").toggle();
	    });


        function initialize_result() {
            //Initialise la zone des marqueurs
            var zoneMarqueurs = new google.maps.LatLngBounds();

            //Affichage Carte
            var options_map = {
                center: latlng,
                maxZoom: 18,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.LARGE,
                    position: google.maps.ControlPosition.RIGHT_BOTTOM
                },
                disableDefaultUI: true,
                streetViewControl: false,
                scrollwheel: false // pour virer le zoom scroll qui était chiant
            };
            var carte = new google.maps.Map(document.getElementById("google_map_results"), options_map);


            //Marking the user's position
            <?php if ($location_coords [0] != 0 && $location_coords [1] != 0) : ?>
                var latlng = new google.maps.LatLng(<?=$location_coords[0];?>, <?=$location_coords[1];?>);

                var myPosition = new google.maps.Marker({
                    position: latlng,
                    map: carte,
                    icon: '/img/marker_home.png',
                    title: "Votre Adresse"
                });
                zoneMarqueurs.extend(myPosition.getPosition());
            <?php endif; ?>

            //Marking the owner's/product's position

            <?php if ($lat != 0 && $lng != 0) : ?>
                var latlng = new google.maps.LatLng(<?=$lat;?>, <?=$lng;?>);

                var myPosition = new google.maps.Marker({
                    position: latlng,
                    map: carte,
                    //icon: 'img/marker_home.png',
                    title: "<?php echo $prodName; ?>"
                });
                zoneMarqueurs.extend(myPosition.getPosition());
            <?php endif; ?>

            carte.fitBounds(zoneMarqueurs);
        }

        google.maps.event.addDomListener(window, 'load', initialize_result);



        req_date_from = $("#debutDate").val() ? $("#debutDate").val() : 'XXX';
        req_date_to = $("#finDate").val() ? $("#finDate").val() : 'XXX';

        var message_1 = "Bonjour <?php echo $prodOwner['user_firstname'] . ' ' . $prodOwner['user_lastname'] ?>,\n"
            + "Je souhaite t'emprunter l'objet <?php echo $art->prod_name ?> du ";
        var message_2 = " au ";
        var message_3 = ", quand puis-je venir le chercher ? Merci pour ta réponse.\n"
            + "<?php if (\Session::Online()) { echo \Session::Me()->user_firstname; } ?>";
        $('#content').html(message_1 + req_date_from + message_2 + req_date_to + message_3);


        $(".dateSelect").change(function () {
            req_date_from = $("#debutDate").val();
            req_date_to = $("#finDate").val();

            $('#content').html(message_1 + req_date_from + message_2 + req_date_to + message_3);
        });


        var date = new Date();
        var liste_date = <?php
        if(str_replace(",", "\",\"", $art->getAttr('dates'))=="") {
            echo "'NULL'";
        }
        else{
            echo str_replace(",", ",", $art->getAttr('dates'));
        }
        ?>;



        if(liste_date == 'NULL'){
            $('#calendar').multiDatesPicker({
                dateFormat: 'yy-mm-dd',
                disable:true,
                addDates: liste_date,
                minDate:'today',
                onSelect:function(a,b){ return false; }
            });
        }else{
            $('#calendar').multiDatesPicker({
                minDate:'today',
                dateFormat: 'yy-mm-dd',
                disable:true,
                altField: '#input-dates',
                onSelect:function(a,b){ return false; }
            });
        }






    });

    $('#debutDate').datetimepicker({
        timepicker:false,
        formatDate:'Y/m/d',
        lang:'fr',
        format:'Y/m/d',
        onShow:function( ct ){
            this.setOptions({
                maxDate:$('#finDate').val()?$('#finDate').val():false
            })
        }
    });

    $('#finDate').datetimepicker({
        timepicker:false,
        formatDate:'Y/m/d',
        lang:'fr',
        format:'Y/m/d',
        onShow:function( ct ){
            this.setOptions({
                minDate:jQuery('#debutDate').val()?jQuery('#debutDate').val():false
            })
        }
    });




</script>

