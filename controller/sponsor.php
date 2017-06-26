<?php

namespace Controller;

use \Site;

if (!\Session::online()) {
    Site::redirect(WEBDIR);
}


$action = new SponsorController();

class SponsorController
{
    private $alreadyRegistered = 0;
    private $alreadySponsored = 0;
    private $mails = [];

    public function __construct()
    {
        try {
            $this->newActionFactory();
        } catch (\Exception $e) {
            \Site::message($e->getMessage(), 'ERROR');
        }
    }


    private function newActionFactory()
    {
        $mails = array();
        if (isset($_GET['module']) && !empty($_GET['module'])) {
            $module = $_GET['module'];
            $action = sprintf("%sAction", $module);
            if (method_exists($this, $action)) {
               $this->$action();
            }
        }

        $this->indexAction();
    }

    private function indexAction()
    {
        $url['gmail'] = WEBDIR . 'sponsor/gmail';
        $url['yahoo'] = WEBDIR . 'sponsor/yahoo';
        $url['outlook'] = WEBDIR . 'sponsor/outlook';

        $mails = $this->mails;
        $alreadyRegistered = $this->alreadyRegistered;
        $alreadySponsored = $this->alreadySponsored;
        include(Site::include_view('sponsor'));
    }

    private function addAction()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            \Site::redirect(WEBDIR . 'sponsor');
        }

        $action = new \listener\subject\action($this);

        $emails = \Site::obtain_post('liste_tags');
        $emails = explode(',', $emails);
        foreach ($emails as $email) {
            $sponsor = new \sponsor();
            $sponsor->spon_user_id = \Session::Me()->user_id;
            $sponsor->spon_email = $email;
            $sponsor->spon_date_creation = date('Y-m-d H:i:s');
            $sponsor->spon_unsubscribe_code = hash('sha1', time() . uniqid());
            $sponsor->Insert();

            $action->attach(new \listener\observer\mail($email));
        }
    }


    private function manageMail($mail)
    {
        if (!is_string($mail)) {
            return false;
        }
        if (!preg_match("/^([a-zA-Z0-9]+(([\.\-\_]?[a-zA-Z0-9]+)+)?)\@(([a-zA-Z0-9]+[\.\-\_])+[a-zA-Z])/", $mail)) {
            return false;
        }

        if (\user::getByEmail($mail)) {
            $this->alreadyRegistered++;
        } else if (\sponsor::exists($mail)) {
            $this->alreadySponsored++;
        } else {
            $this->mails[] = $mail;
        }
    }


    private function gmailAction()
    {
        require_once(__DIR__ . '/../lib/GoogleContacts/autoload.php');
        $client = new \Google_Client();
        $client->setApplicationName('Récupération Contacts GMail');
        $client->setClientId(GOOGLE_API_KEY);
        $client->setClientSecret(GOOGLE_API_SECRET);
        $client->setRedirectUri(GOOGLE_API_OAUTH2_REDIRECT);
        $client->setScopes('https://www.googleapis.com/auth/contacts.readonly');
        $client->setAccessType('online');


        if (!isset($_GET['code'])) {
            \Site::redirect($client->createAuthUrl());
        } else {
            $alreadyRegistered = 0;

            $client->authenticate($_GET['code']);
            $tk = $client->getAccessToken();
            $client->setAccessToken($tk);
            $token = json_decode($tk);
            $token->access_token;
            $curl = curl_init(
                "https://www.google.com/m8/feeds/contacts/default/full?alt=json&max-results=5000&access_token=" . $token->access_token
            );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            $contacts_json = curl_exec($curl);
            $contacts = json_decode($contacts_json, true);
            foreach ($contacts['feed']['entry'] as $contact) {
                @$mail = $contact['gd$email'][0]['address'];
                $this->manageMail($mail);
            }

        }
    }


    private function outlookAction()
    {
        //Outlook
        $url_outlook = '';
        $mails_outlook = '';

        $client_id = OUTLOOK_CLIENT_ID;
        $client_secret = OUTLOOK_CLIENT_SECRET;
        $redirect_uri = WEBDIR . 'sponsor/outlook';

        if (!isset($_GET['code'])) {
            \Site::redirect('https://login.live.com/oauth20_authorize.srf?client_id='.$client_id.'&scope=wl.basic%20wl.contacts_emails&response_type=code&redirect_uri='.$redirect_uri);
        } else {
            $auth_code = $_GET["code"];
            $fields = array(
                'code' => urlencode($auth_code),
                'client_id' => urlencode($client_id),
                'client_secret' => urlencode($client_secret),
                'redirect_uri' => urlencode($redirect_uri),
                'grant_type' => urlencode('authorization_code')
            );
            $post = '';
            foreach ($fields as $key => $value) {
                $post .= $key . '=' . $value . '&';
            }
            $post = rtrim($post, '&');
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://login.live.com/oauth20_token.srf');
            curl_setopt($curl, CURLOPT_POST, 5);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($result);
            if (isset($response->error)) {
                throw new \Exception($response->error_description);
            }
            $accesstoken = $response->access_token;
            $url = 'https://apis.live.net/v5.0/me/contacts?access_token=' . $accesstoken . '&limit=100';
            $xmlresponse = file_get_contents($url);
            $xml = json_decode($xmlresponse, true);
            $msn_email = "";
            foreach ($xml['data'] as $emails) {
                $mail = $emails['emails']['preferred'];
                $this->manageMail($mail);
            }
        }

    }

    private function yahooAction()
    {

        //Yahoo
        require_once('./lib/YahooContacts/OAuth2.class.php');
        $AuthYahoo = new \OAuth2();
        $redirect_uri_yahoo = WEBDIR . 'sponsor/yahoo';

        if (!isset($_GET['code'])) {
            \Site::redirect($AuthYahoo->getAuthorizationURL(YAHOO_CONSUMER_KEY,$redirect_uri_yahoo));
        } else {
            $token = $AuthYahoo->get_access_token(
                YAHOO_CONSUMER_KEY,
                YAHOO_CONSUMER_SECRET,
                $redirect_uri_yahoo,
                $_GET['code']
            );
            $headers = array(
                'Authorization: Bearer ' . $token,
                'Accept: application/json',
                'Content-Type: application/json'
            );
            $guid = $AuthYahoo->get_last_guid();
            $url_yahoo_contacts = 'https://social.yahooapis.com/v1/user/' . $guid . '/contacts;email';
            $resp = $AuthYahoo->fetch($url_yahoo_contacts, $postdata = "", $auth = "", $headers);
            $jsonResponse = json_decode($resp);

            foreach ($jsonResponse->contacts->contact as $contact) {

                foreach ($contact->fields as $field) {
                    if ('email' === $field->type) {
                        $mail = $field->value;
                        $this->manageMail($mail);
                        break;
                    }
                }

            }
        }

    }
}