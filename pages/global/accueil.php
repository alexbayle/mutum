<style>
    div.content {
        box-sizing: border-box;
        clear: both;
        padding: 40px 10px 0px 10px;
        width: 100%;
        min-height: 712px;
    }
</style>


<div class="row">
    <div class="col-xs-18 col-sm-18 col-md-18 col-lg-18 presentation" style="padding: 0;">
        <div class="col-md-18 col-sm-18 bug" style="margin-bottom: 10px;margin-left: 10px;width: 98%;background-color: #e6e6e6;">
            <h2>bienvenue sur la nouvelle version de mutum !<br/>aidez-nous à corriger les éventuels bugs en les signalant  <a href="<?=WEBDIR?>help/bug">ici</a> ! merci !</h2>
        </div>
        <div class="col-md-18 col-sm-18 xs-hidden tel-hidden" id="accueil">

            <div class="col-md-4 col-sm-4 menu_accueil" style="padding: 0;">
                <ul>
                    <li id="empruntes"><a>les plus empruntés</a></li>
                    <li id="notes"><a>les mieux notés</a></li>
                    <?php
                    if(Session::Online()){
                        ?>
                        <li id="objets"><a>mes objets</a></li>
                    <?php
                    }else {
                    ?>
                
                    <?php
                    }
                    ?>
                </ul>
                <hr style="margin-top: 20px; width: 80%;margin-left: 10%;"/>
            </div>
            <div class="col-md-13 col-sm-13 objets_accueil box">
                <div class="col-md-1 col-sm-1 left" style="padding: 0; z-index:1;">
                    <div class='arrow_left' id='slide_left'>
                        <img src='<?= WEBDIR ?>img/whitearrowleft.png' style='position: absolute;width: 13px;height: 15px;top: 45%;left: 30%;cursor: pointer;'>
                    </div>
                </div>

                <!-- Aléatoire -->
                <div class="col-md-16 col-sm-16" id="rand100" style="padding: 0;margin-top: 30px;height: 363px;">
                   

                </div>
                <!-- Les plus empruntés -->

                <div class="col-md-16 col-sm-16" id="lesplusempruntes" style="display:none;padding: 0;margin-top: 30px;height: 363px;">


                </div>

                <!-- Les mieux notés -->


                <div class="col-md-16 col-sm-16" id="lesmieuxnotes" style="display:none;padding: 0;margin-top: 30px;height: 363px;">
                   
                </div>



                <?php
                    if(Session::Online()){
                ?>
                    <div class="col-md-16 col-sm-16" id="mesobjets"
                         style="display:none;padding: 0;margin-top: 30px;height: 363px;">

                    </div>
                <?php
                }else{
                ?>

                <?php
                }
                ?>
                <div class="col-md-1 col-sm-1 right" style="padding: 0;">
                    <div class='arrow_right' id='slide_right'>
                        <img src='<?= WEBDIR ?>img/whitearrowright.png' style='position: absolute;width: 13px;height: 15px;top: 45%;left: 30%;cursor: pointer;'>
                    </div>
                </div>
            </div>

    </div>
    <div class="col-md-18 col-sm-18" style="padding: 0;">
        <div class="col-md-18 col-sm-18 pres">
            <div class='col-xs-18 col-sm-12 col-md-12 col-lg-12 whatismutum'>
                <div class="col-md-18 col-sm-18">
                    <h1 style="padding: 100px 80px 15px 80px;"><span class='blue'>mutum,</span> c'est quoi ?</h1>
                </div>
                <div class="col-xs-18 col-sm-18 col-md-18 col-lg-18 quoi">
                    <div class='text_1'>
                        <p>
                            gagnez des mutums en partageant vos objets,<br />
                            et utilisez vos mutums pour emprunter gratuitement !
                        </p>
                    </div>
                    <div class='text_2'>
                        <p>finalement avec mutum :</p>
                        <ul>
                            <li>vous faites des économies</li>
                            <li>vous rencontrez vos voisins</li>
                            <li>vous participez à une économie responsable et circulaire : acheter,<br />
                                utiliser, réutiliser, revaloriser, réemployer… les objets de votre quotidien !</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='col-xs-18 col-sm-18 col-md-6 col-lg-6 theconcept'>
                <div class='video'>
                    <iframe class=".iframe"style='width:340px;height:220px;' id="videoyoutube" src="http://www.youtube.com/embed/mmGL60ZF_-M" frameborder="0" allowfullscreen></iframe>
                    <script type="text/javascript">
                        $('.iframe').css({'border-radius' : '10px'})
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" style="background-color: #e6e6e6;margin: 0;">
    <div class="col-xs-18 col-sm-18 col-md-18 col-lg-18 infos">
        <div class='col-xs-18 col-sm-18 col-md-6 col-lg-6 explain'>
            <div class='img'>
                <img src='<?=WEBDIR?>img/picto/security.png' style='height:100%;'>
            </div>
            <h2>sécurité</h2>
            <div class='info purple'>caution par empreinte de carte, traçabilité des échanges</div>
        </div>

        <div class='col-md-6 col-sm-18 col-xs-18 explain'>
            <div class='img'>
                <img src='<?=WEBDIR?>img/picto/confiance.png' style='height:100%;'>
            </div>
            <h2>simplicité</h2>
            <div class='info green'>je prête et j'emprunte ce que je veux, quand je veux et à qui je veux</div>
        </div>

        <div class='col-md-6 col-sm-18 col-xs-18 explain'>
            <div class='img'>
                <img src='<?=WEBDIR?>img/picto/reciprocite.png' style='height:100%;'>
            </div>
            <h2>réciprocité</h2>
            <div class='info darkorange'>chaque action collaborative rapporte des mutum pour permettre des échanges.</div>
        </div>
        <div class="col-md-18 col-sm-18 col-xs-18">
            <hr />
        </div>
        <div class="col-md-18 col-sm-18 col-xs-18 onparledenous">
            <h2>on parle de <span class='blue'>vous</span></h2>
            <ul>
                <li><img src="<?=WEBDIR?>img/picto/ent1.png"  class="ent1" alt=""/></li>
                <li><img src="<?=WEBDIR?>img/picto/ent2.png"  class="ent2" alt=""/></li>
                <li><img src="<?=WEBDIR?>img/picto/ent3.png"  class="ent3" alt="" /></li>
                <li><img src="<?=WEBDIR?>img/picto/ent4.png" class="ent4" alt=""/></li>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        var selectedCategorie = '#rand100';
        var page = 0;

        $(document).ready(function() {

            $('#slide_right').on('click', function() {
               // var url = 'index.php';
                //$('#accueil').load(url + ' #gallery');
                page++;
                afficherCarousel("droite",selectedCategorie,page);

            });
            $('#slide_left').on('click', function() {
               // var url = 'index.php';
               // $('#accueil').load(url + ' #gallery');
                page--;
                afficherCarousel("gauche",selectedCategorie,page);
                 
            });
        });

        function hideAll(){
            $('#mesobjets').hide().html('');
            $('#lesplusempruntes').hide().html('');
            $('#lesmieuxnotes').hide().html('');
            $('#rand100').hide().html('');
        }
        hideAll();
        $('#rand100').show();

        $('#empruntes').click(function(){
            hideAll();
            $('#lesplusempruntes').show();
            $('#notes').removeClass('bgblue1');
            $('#objets').removeClass('bgblue1');
            $(this).addClass('bgblue1');
            selectedCategorie = '#lesplusempruntes';
            page = 0;
            afficherCarousel(null,selectedCategorie,page);
        });

        $('#notes').click(function(){
           hideAll();
           $('#lesmieuxnotes').show();
            $('#empruntes').removeClass('bgblue1');
            $('#objets').removeClass('bgblue1');
            $(this).addClass('bgblue1');
            selectedCategorie = '#lesmieuxnotes';
            page = 0;
            afficherCarousel(null,selectedCategorie,page);
        });

        $('#objets').click(function(){
           hideAll();
           $('#mesobjets').show();
            $('#notes').removeClass('bgblue1');
            $('#empruntes').removeClass('bgblue1');
            $(this).addClass('bgblue1');
            selectedCategorie = '#mesobjets';
            page = 0;
            afficherCarousel(null,selectedCategorie,page);
        });


        function afficherCarousel(sens,categorie,page){
    
            $.post('<?=AJAXLOAD?>afficherObjetsCaroussel', {categorie : categorie, page : page}, function(data, textStatus, xhr) {
                    $(categorie).html(data);
                    if(sens=="gauche"){
                        $(categorie).animate({'left':'-='+$(categorie).width(),'opacity':'0'},0);
                        $(categorie).animate({'left':'+='+$(categorie).width(),'opacity':'1'},500);
                    }
                    if(sens=="droite"){
                        $(categorie).animate({'left':'+='+$(categorie).width(),'opacity':'0'},0);
                        $(categorie).animate({'left':'-='+$(categorie).width(),'opacity':'1'},500);
                    }
                    hover();
                        
                });

        }
        afficherCarousel(null,'#rand100',0);

        function hover(){
            $('.carr_link_class').hover(function(){
                var id = $(this).prop('id').replace('carr_link_','');
                $('#carr_hover_'+id).show();
            },function(){
                var id = $(this).prop('id').replace('carr_link_','');
                $('#carr_hover_'+id).hide();
            });
        }
    });
</script>