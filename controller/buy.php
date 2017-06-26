<?php

namespace Controller;

use \Site;

if (!\Session::online()) {
    \Site::redirect(WEBDIR);
}


$action = new BuyController();


class BuyController
{

    public function __construct()
    {
        try {
            $this->actionFactory();
        } catch (\Exception $e) {
            \Site::message($e->getMessage(), 'ERROR');
        }
    }

    private function actionFactory()
    {
        if (!isset($_GET['module'])) {
            Site::redirect(WEBDIR . "success/wallet");
        } else {
            if (isset($_GET['action']) && $_GET['action'] == 'confirm') {
                include(Site::include_view('confirm'));
            } else {
                if (!$this->checkOffer($_GET['module'])) {
                    Site::redirect(WEBDIR . 'success/wallet');
                }

                $this->checkoutAction($_GET['module']);
            }
        }
    }

    private function checkOffer($offerSlug)
    {
        $offer = \buy::getOneBySlug($offerSlug);
        if (!$offer) {
            return false;
        }

        return true;
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

    private function checkoutAction($offerSlug)
    {
        $mangoPayApi = $this->initializeMango();
        $offer = \buy::getOneBySlug($offerSlug);
        $userMangoId = \Session::Me()->user_mangopay_id;


        if (!isset($_GET["CreatedCardRegisterId"])) {
            //setup the card registration
            $CardRegistration = new \MangoPay\CardRegistration();
            $CardRegistration->UserId = $userMangoId;
            $CardRegistration->Currency = "EUR";
            $CreatedCardRegister = $mangoPayApi->CardRegistrations->Create($CardRegistration);//Send the request
            include(\Site::include_view('checkout'));
            die;
        } else {
            $CardRegister = $mangoPayApi->CardRegistrations->Get($_GET["CreatedCardRegisterId"]);
            $CardRegister->RegistrationData = isset($_GET['data']) ? 'data=' . $_GET['data'] : 'errorCode=' . $_GET['errorCode'];
            $UpdatedCardRegister = $mangoPayApi->CardRegistrations->Update($CardRegister);
            if ($UpdatedCardRegister->Status != 'VALIDATED' || !isset($UpdatedCardRegister->CardId)) {
                die('Couldnt register the card. Payment has not been created.<div>');
            }
            $CardPreAuthorization = new \MangoPay\CardPreAuthorization();
            $CardPreAuthorization->AuthorId = $userMangoId;
            $CardPreAuthorization->DebitedFunds = new \MangoPay\Money();
            $CardPreAuthorization->DebitedFunds->Currency = "EUR";
            $CardPreAuthorization->DebitedFunds->Amount = $offer['buy_price'] * 100;
            $CardPreAuthorization->SecureMode = "DEFAULT";
            $CardPreAuthorization->CardId = $UpdatedCardRegister->CardId;
            $CardPreAuthorization->SecureModeReturnURL = WEBDIR . "buy/{$offerSlug}/auth";

            $CreatePreAuthorization = $mangoPayApi->CardPreAuthorizations->Create($CardPreAuthorization);

            $PayIn = new \MangoPay\PayIn();
            $PayIn->CreditedWalletId = \mangopay::get_site_infos()['mang_wallet'];
            $PayIn->AuthorId = $userMangoId;
            $PayIn->PaymentType = "PREAUTHORIZED";
            $PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsPreAuthorized();
            $PayIn->PaymentDetails->PreauthorizationId = $CreatePreAuthorization->Id;
            $PayIn->DebitedFunds = new \MangoPay\Money();
            $PayIn->DebitedFunds->Currency = "EUR";
            $PayIn->DebitedFunds->Amount = $offer['buy_price'];
            $PayIn->Fees = new \MangoPay\Money();
            $PayIn->Fees->Currency = "EUR";
            $PayIn->Fees->Amount = 0;
            $PayIn->ExecutionType = "DIRECT";
            $PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
            $PayIn->ExecutionDetails->ReturnURL = WEBDIR . "buy/{$offer['buy_slug']}/confirm";
            $PayIn->ExecutionDetails->CardId = $UpdatedCardRegister->CardId;


            $CreatePayIn = $mangoPayApi->PayIns->Create($PayIn);//Send the request

            if ($CreatePayIn->Status == 'SUCCEEDED') {
                $transaction = new \transaction();
                $transaction->tran_payin_id = $CreatePayIn->Id;
//                $transaction->tran_offer;
                $transaction->tran_card_id = $PayIn->ExecutionDetails->CardId;
                $transaction->tran_date_creation = date('Y-m-d H:i:s', $CreatePayIn->CreationDate);
                $transaction->tran_user_id = \Session::Me()->user_id;

                $transaction->Insert();

                \Session::Me()->addCredit($offer['price']);
                \Session::Me()->addScore($offer['price']);
                \Session::Me()->Update();

                \Site::message('Paiment ok');
                \Site::redirect(WEBDIR . "buy/{$offerSlug}/confirm");
            } else {
                throw new \RuntimeException("Error : " . $CreatePayIn->ResultMessage);
            }
        }

        include(Site::include_view('card'));
    }


}