<!--<h3>Enregistrer une nouvelle carte:</h3>

<form action="<?php echo $CreatedCardRegister->CardRegistrationURL; ?>" method="post">
    <input type="hidden" name="data" value="<?php echo $CreatedCardRegister->PreregistrationData; ?>" />
    <input type="hidden" name="accessKeyRef" value="<?php echo $CreatedCardRegister->AccessKey; ?>" />
    <input type="hidden" name="returnURL" value="<?php echo 'http' . ( isset($_SERVER['HTTPS']) ? 's' : '' ) . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?CreatedCardRegisterId='.$CreatedCardRegister->Id; ?>" />

    <label for="cardNumber">Numéro de carte</label>
    <input type="text" name="cardNumber" value="" maxlength="16" id="new_number" />

    <label for="cardExpirationDate">Date d'expiration</label>
    <input type="text" name="cardExpirationDate" value="1016" />

    <label for="cardCvx">Cryptogramme</label>
    <input type="text" name="cardCvx" value="123" />

    <input type="submit" value="Payer" />
</form>-->

<div class="row2">
    <div class="col-md-18 preter">
        <h2>Enregistrer une nouvelle carte:</h2>
        <div class="col-md-18">
            <form action="<?php echo $CreatedCardRegister->CardRegistrationURL; ?>" method="post">
                <div class="col-md-9">
                    <div class="col-md-18 demande_item">
                        <label for="cardNumber">Numéro de carte</label>
                        <input maxlength='16' id='new_number' name='cardNumber' class='new_card' type='text'>
                    </div>
                    <div class="col-md-18 demande_item">
                        <div class="col-md-8"style="padding: 0;">
                            <label for="cardExpirationDate">Date d'expiration</label>
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
                        <label for="cardCvx">Cryptogramme</label>
                        <input type="text" name="cardCvx" value="" />
                    </div>
                    <div class="send" style="float: right; margin-top: 20px;margin-right: 28px;">
                        <input type="submit" value="Enregistrer" name="envoie" />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-18" style="margin-top: 20px;">
                        <p>Les cautions ne peuvent être débitées que sur demande du prêteur à la fin d'un échange avec caution, et uniquement avec votre accord. Les cartes vous servent aussi à acheter des mutum sur la page<a href="<?=WEBDIR?>success/wallet" class="blue"> acheter des mutum</a>.</p>
                    </div>
                    <br />
                    <div class="col-md-18" style="margin-top: 20px">
                        <p>Une pré-autorisation de 1 € sera réalisée sur votre carte bleue afin d'en valider le fonctionnement auprès de notre partenaire bancaire. Selon les banques, cette somme peut être bloquée, mais sera alors débloquée dans une semaine.</p>
                    </div>

                </div>

                <input type="hidden" name="data" value="<?php echo $CreatedCardRegister->PreregistrationData; ?>" />
                <input type="hidden" name="accessKeyRef" value="<?php echo $CreatedCardRegister->AccessKey; ?>" />
                <input type="hidden" name="returnURL" value="<?php echo 'http' . ( isset($_SERVER['HTTPS']) ? 's' : '' ) . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?CreatedCardRegisterId='.$CreatedCardRegister->Id; ?>" />

            </form>
        </div>
    </div>
</div>