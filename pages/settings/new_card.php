<div class="row2">
    <div class="col-md-18 title">
        <h1>nouvelle carte</h1>
    </div>
    <div class="col-md-18 menu_onglet"style="padding-left: 0;padding-right: 0">
        <?php include_once('header.php') ?>
    </div>
    <?php
    //setup the card registration
    $CardRegistration = new \MangoPay\CardRegistration();
    $CardRegistration->UserId = $userMangoId;
    $CardRegistration->Currency = "EUR";
    //Send the request
    $CreatedCardRegister = $mangoPayApi->CardRegistrations->Create($CardRegistration);
    ?>
    <div class="col-md-18 preter">
        <h2>enregistrer une nouvelle carte :</h2>
        <div class="col-md-18">
            <form action="<?php echo $CreatedCardRegister->CardRegistrationURL; ?>" method="post">
                <div class="col-md-9">
                    <div class="col-md-18 demande_item">
                        <label for="cardNumber">numéro de carte</label>
                        <input maxlength='16' id='new_number' name='cardNumber' class='new_card' type='text'>
                    </div>
                    <div class="col-md-18 demande_item">
                        <div class="col-md-8"style="padding: 0;">
                            <label for="cardExpirationDate">date d'expiration</label>
                        </div>
                        <div class="col-md-4">
                            <input maxlength='2' id='new_month' class='new_card' type='text' placeholder='MM' style='width: 70px'>
                        </div>
                        <div class="col-md-1" style="padding-top: 3px;">/</div>
                        <div class="col-md-4" style="float: right;">
                            <input maxlength='2' id='new_year' class='new_card' type='text' placeholder='AA' style='width: 70px;'>
                        </div>
                        <input type='hidden' id='new_date' name='cardExpirationDate' >
                    </div>
                    <div class="col-md-18 demande_item">
                        <label for="cardCvx">cryptogramme</label>
                        <input type="text" name="cardCvx" value="" />
                    </div>
                    <div class="send" style="float: right; margin-top: 20px;margin-right: 28px;">
                        <input type="submit" value="Enregistrer" name="envoie" />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-18" style="margin-top: 20px;">
                        <p>les cautions ne peuvent être débitées que sur demande du prêteur à la fin d'un échange avec caution, et uniquement avec votre accord. les cartes vous servent aussi à acheter des mutums sur la page<a href="<?=WEBDIR?>success/wallet" class="blue"> acheter des mutums</a>.</p>
                    </div>
                    <br />
                    <div class="col-md-18" style="margin-top: 20px">
                        <p>une pré-autorisation de 1 € sera réalisée sur votre carte bleue afin d'en valider le fonctionnement auprès de notre partenaire bancaire. selon les banques, cette somme peut être bloquée, mais sera débloquée une semaine plus tard.</p>
                    </div>

                </div>

                <input type="hidden" name="data" value="<?php echo $CreatedCardRegister->PreregistrationData; ?>" />
                <input type="hidden" name="accessKeyRef" value="<?php echo $CreatedCardRegister->AccessKey; ?>" />
                <input type="hidden" name="returnURL" value="<?php echo 'http' . ( isset($_SERVER['HTTPS']) ? 's' : '' ) . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?CreatedCardRegisterId='.$CreatedCardRegister->Id; ?>" />

            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#new_number').keyup(function(){
        if($(this).val().length==16)
            $('#new_month').focus();
    });

    $('#new_month').keyup(function(){
        if($(this).val().length==2)
            $('#new_year').focus();
        $('#new_date').val($(this).val() + $('#new_year').val());
    });

    $('#new_year').keyup(function(){
        if($(this).val().length==2)
            $('#new_code').focus();
        $('#new_date').val($('#new_month').val() + $(this).val());
    });

</script>