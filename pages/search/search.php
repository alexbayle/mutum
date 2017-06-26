<div class="row2">
    <div class="col-md-18 title">
        <h1>résultat(s)</h1>
    </div>
    <div class='col-md-6' style='height:500px;'>
        <div class='col-md-18'  id='google_map_results' style='border-radius:10px;height:500px;'></div>
    </div>
    <div class='col-md-12'>
        <div class='col-md-18' style='border-radius:10px;background-color:#f3f3f3;'>
            <?php
            if($tab_art_search != array()) {
                $cptSearch = 1;
                $cpt;
                $tab_marker = array();
                foreach ($tab_art_search as $a) {
                    ?>
                    <div class='col-md-18'>
                        <div class='col-md-18 surligneur' data-surligneur='<?= $cptSearch - 1; ?>'
                             style='border-bottom:1px solid #d0d0d0;padding:20px 0px;'>
                            <div class='col-md-4' style='height:105px;padding-left:0px;'>
                                <?= $a[0]->print_picture(100, 'round'); ?>
                            </div>
                            <div class='col-md-10' style='margin-left:-5px;'>
                                <div class='blue bold'>
                                    <?= $cptSearch + $offset ?> . <a class='blue'
                                                                     href="<?= WEBDIR ?>view?module=<?= $a[0]->getAttr('id'); ?>"><?= $a[0]->getAttr('name'); ?></a>
                                    <span><?= $a[0]->getNoteMoy($a[0]->getAttr('id')); ?></span>
                                </div>
                                <div style='padding:5px 0 0 20px;'>
                                    <div style='float:left;margin-top:2px;'>
                                        <?= $a[1]->print_user(16, 'profile') ?>
                                    </div>
                                    <div class='blue' style='float:left;margin-left:10px;'>

                                        <a class='blue'
                                           href="<?= WEBDIR ?>user?module=<?= $a[1]->getAttr('id'); ?>"><?= $a[1]->printName() ?></a>

                                    </div>
                                    <?= $a[1]->printNote($a[1]->getAttr('nb_notation'),round($a[1]->getAttr('notation'))) ?>
                                    <div
                                        style='background-color:rgb(222,76,115);border-radius:5px 5px 0 5px;color:white;float:left;font-size:0.8em;margin-left:10px;padding:2px 8px;'>
                                        <?= $a[4]->getSmallAddress(); ?>
                                    </div>
                                </div>

                                <br/><br/>

                                <div class='results_small_font'>
                                    <div class='bold'>Description:</div>
                                    <div style=''>
                                        <p style="height: 39px;overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;"><?= $a[0]->getAttr('desc'); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-4' style='padding-left:0px;padding-right:0px;'>
                                <div class='orange'>
                                    <span style='font-size:2.5em;'><?= $a[0]->getMutumByDay(); ?></span>
                                    <img alt='number_mutum' src='<?= WEBDIR ?>/img/search_mutum_day.png'
                                         style='width:30px;'>
                                    <span style='font-size:1.1em;'>/ jour</span>
                                </div>
                                <br/>

                                <div class='results_small_font'>
                                    <span class='bold'>Caution : </span>
                                    <?php
                                    $caution = $a[0]->getAttr('caution');
                                    if ($caution == 0) {
                                        echo 'Non';
                                    } else {
                                        echo $caution . ' €';
                                    }
                                    ?>
                                    <br/>
                                    <span class='bold'>Ville : </span>
                                    <?= $a[4]->getSmallAddress(); ?>
                                    <br/>
                                    <span class='bold'>Distance : </span>
                                    <?= address::getDistance($a[4]->getAddress(), $location_coords); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    array_push($tab_marker, array($a[4]->getAttr('latitude'), $a[4]->getAttr('longitude'), $a[0]->getAttr('name')));
                    $cptSearch++;
                }
            }else{
                ?>
                <p>oups, aucun résultat ne correspond à cette recherche !</p>
            <?php
            }
    ?>
                    <div class='search_pagination'>
                        <?php
                            if($max_page > 1) {
                                if($p > 3 && $max_page > 5) {
                                    echo '<a href="?s_a_cat=' . $s_a_cat . '$s_a_name=' . $s_a_name . '&s_a_loc=' . $url_address . '&p=1"> Début </a>' ;
                                }
                                $skip = 0 ;
                                $nb_aff = 0 ;
                                for($i = 1; $i  <=$max_page; $i++) {
                                    if(($i >= $p - 2 && $i <= $p + 2) || $max_page <= 5) {
                                        $skip = 0 ;
                                        echo "<a style='" . ($i==$p?"color:#00a2b0;":"") . "' href='?s_a_cat=" . $s_a_cat . "&s_a_name=" . $s_a_name . "&s_a_loc=" . $url_address . "&p=$i'> $i </a>" ;
                                    } else {
                                        if($skip == 0) {
                                            $skip = 1 ;
                                            print " ... " ;
                                        }
                                    }
                                }
                                if($p < $max_page - 2 && $max_page > 5) {
                                    echo '<a href="?s_a_cat=' . $s_a_cat . '$s_a_name=' . $s_a_name . '&s_a_loc=' . $url_address . '&p=' . $max_page . '"> Fin </a>' ;
                                }
                            }
                        ?>
                    </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function initialize_result() {
        // Initialise la zone des marqueurs
        var zoneMarqueurs = new google.maps.LatLngBounds() ;
        
        // Affichage Carte
        var options_map = {
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            maxZoom: 18,
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
                position: google.maps.ControlPosition.RIGHT_BOTTOM
            },
            disableDefaultUI: true,
            streetViewControl: false
        };
        var carte = new google.maps.Map(document.getElementById("google_map_results"), options_map);
        
        // Affichage marqueur ma position
        <?php
            if($location_coords[0]!=0 && $location_coords[1]!=0) {
        ?>
                // Ma position
                var latlng = new google.maps.LatLng(<?=$location_coords[0];?>,<?=$location_coords[1];?>) ;
                var myPosition = new google.maps.Marker({
                    icon: '<?=WEBDIR?>/img/marker_home.png',
                    map: carte,
                    position: latlng,
                    title: "Votre Adresse"
                });
                zoneMarqueurs.extend(  myPosition.getPosition() ) ;
        <?php
            }
        ?>
        
        // Affichage des marqueurs
        <?php
            $cptMarker = 0 ;
            foreach($tab_marker as $t) {
        ?>
                var latlng = new google.maps.LatLng(<?=$t[0]?>,<?=$t[1]?>) ;
                var Marker_<?=$cptMarker?> = new google.maps.Marker({
                    map: carte,
                    position: latlng,
                    title: "<?=$t[2]?>"
                }) ;
                zoneMarqueurs.extend(  Marker_<?=$cptMarker?>.getPosition() ) ;
        <?php
                $cptMarker++ ;
            }
        ?>
        
        // Annimation Bounce sur les marqueurs au survol d'une div objet
        function GiveAnimation(name_marker) {
            if (eval(name_marker).getAnimation() == null) {
                eval(name_marker).setAnimation(google.maps.Animation.BOUNCE) ;
            }
        }
        function RemoveAnimation(name_marker) {
            if (eval(name_marker).getAnimation() != null) {
                eval(name_marker).setAnimation(null) ;
            }
        }
        $('.surligneur').mouseover(function() {
            GiveAnimation('Marker_' + $(this).attr('data-surligneur')) ;
        }) ;
        $('.surligneur').mouseout(function() {
            RemoveAnimation('Marker_' + $(this).attr('data-surligneur')) ;
        }) ;
        
        carte.fitBounds(zoneMarqueurs) ;
    }
    
    google.maps.event.addDomListener(window, 'load', initialize_result) ;
</script>