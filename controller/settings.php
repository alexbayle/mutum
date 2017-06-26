<?php
namespace Controller;

use MangoPay\MangoPayApi;
use \Site;

if (!\Session::online()) {
    \Site::redirect(WEBDIR);
}

$object = new settingsController();

class settingsController
{
    public function __construct()
    {
        try {
            $this->settingsFactory();
        } catch (\Exception $e) {
            \Site::message($e->getMessage(), 'ERROR');
        }
    }


    private function settingsFactory()
    {
        if (isset($_GET['module']) && !empty($_GET['module'])) {
            $module = $_GET['module'];
            switch ($module) {
                case 'mail':
                    $this->mailAction();
                    break;
                case 'cards':
                    $this->cardsAction();
                    //$this->createLegaluser()
                    break;
                case 'delete_card':
                    $this->deleteCard();
                    break;
                case 'new_card':
                    $this->newcardAction();
                    $this->createCard();
                    break;
            }
        } else {
            Site::redirect(WEBDIR . 'settings/mail');
        }
    }
    private function initializeMango()
    {
        $mangoPayApi = new \MangoPay\MangoPayApi();
        $mangoPayApi->Config->ClientId = MANGOPAY_CLIENT_ID;
        $mangoPayApi->Config->ClientPassword = MANGOPAY_PASSPHRASE;
        $mangoPayApi->Config->TemporaryFolder = MANGOPAYTMP;
        $mangoPayApi->Config->BaseUrl = MANGOPAYAPI;


        return $mangoPayApi;
    }

    private function get_mangopay_id($id){
        return \DB::SqlOne("Select user_mangopay_id from user where user_id='".$id."'");
    }

    private function check_card_owner($card_id,$user_id){
        $mangoPayApi = $this->initializeMango();
        $exist = false;
        $Pagination = new \MangoPay\Pagination();
        $Pagination->Page = 1;
        $Pagination->ItemsPerPage = 100;
        $cards = $mangoPayApi->Users->GetCards($this->get_mangopay_id($user_id),$Pagination);
        var_dump($cards);
        foreach($cards as $c)
        {
            if($c->Id==$card_id)
            {
                $exist=true;
                break;
            }
        }
        return $exist;
    }

    /*private function createLegaluser(){
        try{
        $mangoPayApi = $this->initializeMango();
        $User = new \MangoPay\UserLegal();
        $User->PersonType = "LEGAL";
        $User->LegalPersonType = "BUSINESS";
        $User->Name = "Mutum";
        $User->HeadquartersAddress = "bla";
        $User->LegalRepresentativeFirstName = "Alexandre";
        $User->LegalRepresentativeLastName = "Bayle";
        $User->LegalRepresentativeAdress = "bla";
        $User->LegalRepresentativeEmail = "a@a.fr";
        $User->LegalRepresentativeNationality = "FR";
        $User->LegalRepresentativeCountryOfResidence = "FR";
        $User->LegalRepresentativeBirthday = 602722800;
        $User->Statute = "";
        $User->ProofOfRegistration = "";
        $User->ShareholderDeclaration = "";
        $User->Email = "contact@mutum.fr";
        $User->Tag = "";
        var_dump($User);

        //Send the request
        $mangoPayApi->Users->Create($User);*/

        /*$Wallet = new \MangoPay\Wallet();
        $Wallet->Owners = array("7589495");
        $Wallet->Description = "Mutum.fr Wallet";
        $Wallet->Currency = "EUR";
        $Wallet->Tag = "bla";
        var_dump($Wallet);
        //Send the request
        $mangoPayApi->Wallets->Create($Wallet);*/


        //\MangoPay\Logs::Debug('CREATED LEGAL USER', $User);
        //\MangoPay\Logs::Debug('CREATED WALLET', $Wallet);



        /*} catch (\MangoPay\ResponseException $e) {
            \MangoPay\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
            \MangoPay\Logs::Debug('Message', $e->GetMessage());
            \MangoPay\Logs::Debug('Details', $e->GetErrorDetails());
        }catch (\MangoPay\Exception $e) {
            \MangoPay\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
        }

    }*/

    private function mailAction()
    {
        $notificationCat = \notification_cat::getNotificationCat();;
        settingsController::send_settings();
        include(Site::include_view('mail'));
    }

    private function cardsAction()
    {
        $mangoPayApi = $this->initializeMango();
        $userMangoId = \Session::Me()->user_mangopay_id;

        $Pagination = new \MangoPay\Pagination();
        $Pagination->Page = 1;
        $Pagination->ItemsPerPage = 100;
        $cards = $mangoPayApi->Users->GetCards($userMangoId,$Pagination);

        include(Site::include_view('cards'));
    }

    private function newcardAction()
    {
        $mangoPayApi = $this->initializeMango();
        $userMangoId = \Session::Me()->user_mangopay_id;
        include(Site::include_view('new_card'));
    }

    private function createCard(){

        $envoie = Site::obtain_post('envoie');

        if (isset($_GET["CreatedCardRegisterId"])) {
            $mangoPayApi = $this->initializeMango();
            $userMangoId = \Session::Me()->user_mangopay_id;
            try{
                $cardRegister = $mangoPayApi->CardRegistrations->Get($_GET["CreatedCardRegisterId"]);
                $cardRegister->RegistrationData = isset($_GET['data']) ? 'data=' . $_GET['data'] : 'errorCode=' . $_GET['errorCode'];

                $updatedCardRegister = $mangoPayApi->CardRegistrations->Update($cardRegister);

                if ($updatedCardRegister->Status != 'VALIDATED' || !isset($updatedCardRegister->CardId))
                    Site::message('Cannot create virtual card. Payment has not been created.','Warning');
                die;
            } catch (\MangoPay\ResponseException $e) {
                \Site::message($e->getCode().$e->getMessage(), 'ERROR');
                print_r($e->GetErrorDetails());
            }
            $card_id = $updatedCardRegister->CardId;
            $result = $mangoPayApi->Cards->Get($card_id);

            $CardPreAuthorization = new \MangoPay\CardPreAuthorization();
            $CardPreAuthorization->AuthorId = \mangopay::get_mangopay_id($userMangoId);
            $CardPreAuthorization->DebitedFunds = new \MangoPay\Money();
            $CardPreAuthorization->DebitedFunds->Currency = "EUR";
            $CardPreAuthorization->DebitedFunds->Amount = 100;
            $CardPreAuthorization->SecureMode = "DEFAULT";
            $CardPreAuthorization->CardId = $card_id;
            $CardPreAuthorization->SecureModeReturnURL = WEBDIR . "settings/new_card";


            //Send the request
            $CreatePreAuthorization = $mangoPayApi->CardPreAuthorizations->Create($CardPreAuthorization);

            $PayIn = new \MangoPay\PayIn();
            $PayIn->CreditedWalletId = \mangopay::get_site_infos()['mang_wallet'];
            $PayIn->AuthorId = \mangopay::get_mangopay_id($userMangoId);
            $PayIn->PaymentType = "PREAUTHORIZED";
            $PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsPreAuthorized();
            $PayIn->PaymentDetails->PreauthorizationId = $CreatePreAuthorization->Id;
            $PayIn->DebitedFunds = new \MangoPay\Money();
            $PayIn->DebitedFunds->Currency = "EUR";
            $PayIn->DebitedFunds->Amount = 100;
            $PayIn->Fees = new \MangoPay\Money();
            $PayIn->Fees->Currency = "EUR";
            $PayIn->Fees->Amount = 0;
            $PayIn->ExecutionType = "DIRECT";
            $PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
            $PayIn->ExecutionDetails->ReturnURL = WEBDIR . "settings/cards";
            $PayIn->ExecutionDetails->CardId = $updatedCardRegister->CardId;


            $CreatePayIn = $mangoPayApi->PayIns->Create($PayIn);


            if ($CreatePayIn->Status == 'SUCCEEDED') {
                Site::message('carte enregistrée avec succès','INFO');
            } else {
                // if created Pay-in object has status different than SUCCEEDED
                // that occurred error and display error message
                \Site::message("Error".$result->Status .$result->ResultCode,'WARNING');
            }

            $result = $mangoPayApi->Cards->Get($card_id);
            //var_dump($result);
            Site::redirect5sec(WEBDIR . "settings/cards");
        }
    }

    private function deleteCard(){
        $card_id = Site::obtain_post('card_id');
        $mangoPayApi = $this->initializeMango();
        if(!$this->check_card_owner($card_id,\Session::Me()->getAttr('id')))
        {
            \Site::message('cette carte ne vous appartient pas.','INFO');
        }
        else if(
            \DB::SqlOne("Select count(*)
From caution, request
Where caution.caut_id = request.requ_caut_id
And caut_card_id = '".$card_id."'
And requ_status = 1 or requ_status = 5 or requ_status = 6
And requ_caut_id != Null") > 0)
        {
            \Site::message("cette carte est engagée dans un échange, elle ne peut pas être supprimée avant la fin de l'échange.",'INFO');
        }
        else
        {
            try{
                $Card = $mangoPayApi->Cards->Get($card_id);
                $Card->Active = false;
                $result = $mangoPayApi->Cards->Update($Card);
            } catch (\MangoPay\ResponseException $e) {
                print '<div style="color: red;">'
                    .'\MangoPay\ResponseException: Code: '
                    . $e->getCode() . '<br/>Message: ' . $e->getMessage()
                    .'<br/><br/>Details: '; print_r($e->GetErrorDetails())
                .'</div>';
            }
            $id='card';
        }
    }

    private function send_settings(){
        if(isset($_POST["valider"])){
            //si le post n'existe pas on ajoute dans la bdd => l'utilisateur ne veux pas recevoir de mail
            $user_id = \Session::Me()->getAttr('id');
            //on clear les paramètres existants pour en mettre de nouveaux
            \DB::SqlExec("DELETE FROM notification_user WHERE notu_user_id=". $user_id);
            for ($i=1; $i <= 4; $i++){
                foreach(\notification_mail::getNotificationMail($i) as $notMail){
                    $j=$notMail[0]->getAttr('id');
                    if(!isset($_POST['check_'.$j])) \notification_mail::updateNotificationMail($j,$user_id);
                }   
            }          
        }
    }
}