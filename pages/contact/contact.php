<div class="row2">
    <div class="col-md-18 title">
        <h1>mes contacts</h1>
    </div>
    <div class='col-md-3 menu_contact'>
        <form method='GET'>
            <div class="search_bar">
                <input type='text' id='search' name='search_user' value='<?php echo $search_user;?>' placeholder="rechercher..." >
            </div>
            <div class="loupe" style="height: 0px">
                <button type='submit' style="padding: 0;border: 0;"><img src="<?php WEBDIR ?>img/contact/loupe.png" alt="" style="position: absolute; top: 18px;left:143px;cursor: pointer;"/></button>
            </div>
        </form>
        <hr style="margin-top: 0;">
        <div class="mescontacts">
            <span id="contactMenu">
                tous mes contacts
            </span>
            <div>
                <?php
                $i = 0;
                if($contacts != array()) {
                    echo '<div class="villes" id="villes"><p>villes</p></div>' ;
                        echo "<div class='listevilles' id='listevilles' style='display:none; '>";
                            echo "<div class='listeMenu'>";
                    foreach($cities as $c) {
                            echo "<div class='cityMenu'>";
                                echo "<input type='checkbox' name='check_city' id='check_city' style='display: none;cursor: pointer'/>";
                                echo "<label for='check_city' class='roundbox'></label>";
                                echo "<p>".$c."</p>";
                            echo "</div>";
                        $i++;
                    }
                            echo "</div>";
                    echo "</div>";
                }else{
                    echo '<div class="villes" id="villes"><p>villes</p></div>' ;
                }
                ?>
            </div>
        </div>
        <hr>
        <div id='requestMenu' class='requestMenu'>
            <?php
            if($myAsks != array()) {
                echo '<div class="myasks" id="myasks"><p>mes demandes ('.$nbMyAsks.')</p></div>';
                echo '<div class="listemyask" id="listemyask" style="display: none;">';
                foreach($myAsks as $m) {

                    echo "<div class='ask'>" .$m[0]->printName()."</div>";
                }
                echo "</div>";
            }else{
                echo '<div class="myasks" id="myasks"><p>mes demandes ('.$nbMyAsks.')</p></div>';
            }
            ?>
        </div>

        <div id="demanderecu" class="demanderecu">
             <?php
             if($waitingAsks != array()) {
                 echo '<div class="askreq" id="askreq"><p>demandes reçues ('.$nbMyAskReq.')</p></div>';
                 echo '<div class="listeaskreq" id="listeaskreq" style="display: none;">';
                 foreach($waitingAsks as $w) {

                     echo "<div class='ask'>" .$w[0]->printName()."</div>";
                 }
                 echo "</div>";
             }else{
                 echo '<div class="askreq" id="askreq"><p>demandes reçues ('.$nbMyAskReq.')</p></div>';
             }
             ?>
        </div>

        <div id="ignoreMenu" class="ignored">
            <?php
            if($ignored != array()) {
                echo '<div class="ign" id="ign"><p>personnes ignorées ('.$nbIgnored.')</p></div>';
                echo '<div class="listeignore" id="listeignore" style="display: none;">';
                foreach($ignored as $i) {

                    echo "<div class='personignore'>" .$i[0]->printName()."</div>";
                }
                echo "</div>";
            }else{
                echo '<div class="ign" id="ign"><p>personnes ignorées ('.$nbIgnored.')</p></div>';
            }
            ?>
        </div>
    </div>
    <div class='contact col-md-15' style="width: 81.3333333%;margin-left: 20px;min-height: 282px;">
        <div id='results'>
            <div class="col-md-18" style="margin-top:16px;">
                <span class="titre">résultats de la recherche </span>
                <hr  class="hr" style="margin: 10px 0px 10px 0px">
            </div>
            <div class="col-md-18" style="padding: 0;">
                <?php include(Site::include_view('searchContact')) ; ?>
            </div>
        </div>
        <div id='myContacts' style='margin-bottom:10px;'>
           <div class="col-md-18" style="margin-top:16px;">
               <span class="titre" >mes contacts </span><span id='cityContact'></span>
               <hr  class="hr" style="margin: 10px 0px 10px 0px">
           </div>
           <div class="col-md-18" style="padding: 0;">
                <?php include(Site::include_view('myContacts')) ; ?>
           </div>
        </div>
        <div id='request' style='margin-bottom:10px;'>
            <div class="col-md-18" style="margin-top:16px;">
                <span class="titre">mes demandes</span>
                <hr  class="hr" style="margin: 10px 0px 10px 0px">
            </div>
            <div class="col-md-18" style="padding: 0;">
                <?php include(Site::include_view('myRequest')) ; ?>
            </div>
        </div>
        <div id='ask' style='margin-bottom:10px;'>
            <div class="col-md-18" style="margin-top:16px;">
                <span class="titre">demandes reçues</span>
                <hr  class="hr" style="margin: 10px 0px 10px 0px">
            </div>
            <div class="col-md-18" style="padding: 0;">
                <?php include(Site::include_view('requestFriend')) ; ?>
            </div>
        </div>
        <div id='ignore' style='margin-bottom:10px;'>
            <div class="col-md-18" style="margin-top:16px;">
                <span class="titre">personnes ignorées</span>
                <hr  class="hr" style="margin: 10px 0px 10px 0px">
            </div>
            <div class="col-md-18" style="padding: 0;">
                <?php include(Site::include_view('ignored')) ; ?>
            </div>
        </div>
    </div>
</div>






<script>
    $(document).ready(function(){
        function hideAll() {
            $('#results').hide() ;
            $('#myContacts').hide() ;
            $('.unContact').hide() ;
            $('#cityContact').hide() ;
            $('#request').hide() ;
            $('#ask').hide() ;
            $('#ignore').hide() ;
        }
        
        searchResult = $("#search").val() ;
        
        if(searchResult === '') {
            hideAll() ;
            $('#results').show() ;
        } else {
            hideAll() ;
            $('#results').show() ;
        }
        
        $('#contactMenu').click(function() {
            hideAll() ;
            $('#myContacts').show() ;
            $('.unContact').show() ;
        }) ;
        
        $('.cityMenu').click(function() {
            city = $(this).text() ;
            var label = $(this).find('label');
            $('#cityContact').text('à ' + city) ;
            $(label).css('background-color','#00a2b0');

            hideAll() ;

            $('#myContacts').show();
            $('#cityContact').show() ;
            $('.' + city).show() ;
        }) ;


        
        $('#requestMenu').click(function() {
            hideAll() ;
            $('#request').show() ;
            $('.unContact').show() ;
        }) ;
        $('#demanderecu').click(function(){
            hideAll();
            $('#ask').show();
            $('.unContact').show() ;
        });
        
        $('#ignoreMenu').click(function() {
            hideAll() ;
            $('#ignore').show() ;
            $('.unContact').show() ;
        }) ;

        $('#villes').click(function(){
            $('#listevilles').slideToggle();
        });

        $('#myasks').click(function(){
            $('#listemyask').slideToggle();
        });

        $('#askreq').click(function(){
            $('#listeaskreq').slideToggle();
        });

        $('#ign').click(function(){
            $('#listignore').slideToggle();
        });


    });
</script>