<div class="row2">
    <div class="col-md-18 title">
        <h1>édition du profil</h1>
    </div>
    <div class="col-md-18 edition">
        <form method='POST' enctype="multipart/form-data">
            <div class="col-md-9">
                <h2>informations :</h2>
                <div class="col-md-18 genre">
                <?php
                if (@Session::Me()->GetAttr('sex')=='M')

                    echo "homme :<input type='radio' name='sex' id='sex' value='M' checked> &nbsp femme :<input type='radio' name='sex' id='sex' value='F'><br />";
                else
                    echo "homme :<input type='radio' name='sex' id='sex' value='M' > &nbsp femme :<input type='radio' name='sex' id='sex' value='F' checked><br />";
                ?>
                </div>
                <div class="col-md-18 demande_item">
                    <label for="firstname">prénom :</label>
                    <input type='text' id="firstname" name='firstname' placeholder='votre prenom' value='<?=@Session::Me()->GetAttr('firstname')?>' >
                </div>
                <div class="col-md-18 demande_item">
                    <label for="lastname">nom :</label>
                    <input type='text' id="lastname" name='lastname' placeholder='votre nom' value="<?=@Session::Me()->GetAttr('lastname')?>">
                </div>
                <div class="col-md-18 demande_item">
                    <label for="check_item">souhaitez-vous changer votre mot de passe ?</label>
                    <input type='checkbox' id="check_item" name='btn_pwd' value='1' onclick="hideThis('chk_div','chk_div1','chk_div2')" style="display: block;">
                </div>
                <div class="col-md-18 demande_item" id="chk_div" style="display: none;">
                    <label for="chk_pwd">ancien mot de passe :</label>
                    <input type='password' name='lastpsswd'id='chk_pwd' placeholder=''>
                </div>
                <div class="col-md-18 demande_item" id="chk_div1" style="display: none;">
                    <label for="chk_pwd1">nouveau mot de passe :</label>
                    <input type='password' name='password' id='chk_pwd1' placeholder=''>
                </div>
                <div class="col-md-18 demande_item" id="chk_div2" style="display: none;">
                    <label for="chk_pwd2">confirmer le mot de passe :</label>
                    <input type='password' name='passwordC'id='chk_pwd2' placeholder=''>
                </div>
            </div>
            <div class="col-md-9">
                <div class="col-md-18 demande_item" style="margin-top: 50px;">
                    <label for="picture">choissisez une photo :</label>
                    <input type="file" name="picture" id="picture"/>
                </div>
                <div class="col-md-18 demande_item">
                    <label for="email">email :</label>
                    <input type="email" id="email" name="email" placeholder="email" value="<?= Session::Me()->getAttr('email')?>"/>
                </div>
                <div class="col-md-18 demande_item">
                    <label for="adresse">adresse :</label>
                    <input type='text' id="adresse" name='address'  placeholder='adresse' value='<?= Session::myLoc()->getAddress() ?>'>
                </div>
                <div class="col-md-18 demande_item">
                    <label for="date">date de naissance :</label>
                    <input type="date" id="date" name='birthdate' placeholder='date de naissance' value="<?=@Session::Me()->GetAttr('birthdate')?>">
                </div>
                <div class="col-md-18 demande_item">
                    <label for="phone">téléphone :</label>
                    <input type='text' id="phone" name='phone'  placeholder='Numéro de téléphone' value='<?=@Session::Me()->GetAttr('phone')?>'><br />
                </div>
                <div class="col-md-18 demande_item">
                    <?php
                    if (@Session::Me()->GetAttr('phone_hide')=='1')
                    {
                        echo "<label for='phone_hide'>masquer votre numéro de téléphone</label>";
                        echo " <input type='checkbox' id='phone_hide' name='phone_hide' value='1' checked='checked' style='display: block;'>";
                    }
                    else
                    {
                        echo "<label for='phone_hide1'>masquer votre numéro de téléphone</label>";
                        echo "<input type='checkbox' id='phone_hide1' name='phone_hide' value='1' style='display: block;'>";
                    }

                    ?>
                </div>
                <div style="float: right;">
                    <input type='submit' name='btnconfirm' class="modify" value='modifier'>
                    <input type='submit' name='btncancel' class="reset" value='annuler'>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
function hideThis(_id,_id1,_id2){
    var obj = document.getElementById(_id);
    var obj1 = document.getElementById(_id1);
    var obj2 = document.getElementById(_id2);
    if(obj.style.display == "block" && obj1.style.display == "block" && obj2.style.display == "block")
	{
		obj.style.display = "none";
		obj1.style.display = "none";
		obj2.style.display = "none";
	}
        
    else
	{
        obj.style.display = "block";
        obj1.style.display = "block";
        obj2.style.display = "block";
	}
}


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
</script>

