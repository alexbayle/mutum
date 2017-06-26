<div class="row2">
    <div class="col-md-18 title">
        <h1>Ajout de communauté</h1>
    </div>
    <div class="col-md-18 preter">
        <h2>informations :</h2>
        <form action="" method='POST'>
            <div class="col-md-9">
                <div class="demande_item">
                    <label for="">catégorie:</label>
                    <select name="comm_cat" style="height: 23px;">
                        <?php foreach (community_cat::getAll() as $category) : ?>
                            <option value="<?php echo $category['comc_id'] ?>"><?php echo $category['comc_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="demande_item">
                    <label for="comm_name">nom :</label>
                    <input type="text" id="comm_name" name="comm_name" value="">
                </div>
                <div class="demande_item">
                    <label for="comm_desc">description :</label>
                    <input type="text" id="comm_desc" name="comm_desc" value="">
                </div>
                <div class="demande_item">
                    <label for="comm_addresse">adresse :</label>
                    <input type="text" id="comm_addresse" name="comm_address" value="">
                    <div id="findMe">
                        <img src='<?=WEBDIR?>img/localisation.png' style='cursor:pointer;position:absolute;top: 130px;right: 30px;'>
                    </div>
                </div>
                <div class="send" style="float: right; margin-top: 20px;margin-right: 18px;">
                    <input type="submit">
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        // Auto Complétion des addresse de la barre de recherche
        function initialize_menu() {
            var options_auto = { types: ['address'] };
            var input = document.getElementById('comm_addresse');
            var autocomplete = new google.maps.places.Autocomplete(input,options_auto);
        }
        google.maps.event.addDomListener(window, 'load', initialize_menu);
    });

    function showPosition(position) {
        $.post("/js/ajax/localisation.php" ,{ localisation:position.coords.latitude+','+position.coords.longitude } ,function(data){
            $('#comm_addresse').val(data);
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
</script>