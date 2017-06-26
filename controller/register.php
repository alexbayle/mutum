<?php

namespace Controller;

use MangoPay\MangoPayApi;
use \Site;

define("OK", true);
define("NOK", false);

if (\Session::online()) {
    Site::redirect(WEBDIR);
}

$object = new RegisterController();
$user = $object->getUser();

if ($object->getState() == OK) {
    include(Site::include_view('activate'));
} else {
    include(Site::include_view('register'));
}


class RegisterController
{
    private $user;
    private $state;

    public function __construct()
    {
        try {
            $this->newActionFactory();
        } catch (\Exception $e) {
            \Site::message($e->getMessage(), 'ERROR');
        }
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getState()
    {
        return $this->state;
    }

    private function newActionFactory()
    {
        if (isset($_GET['module']) && !empty($_GET['module'])) {
            \Site::redirect(WEBDIR.'register');
        }elseif (isset($_GET['active'])){
            $this->state = OK;
            $this->activateAccount();
        }else{
            $this->create();
        }
    }

    private function init()
    {
        $this->user = new \user;
        $this->user->user_firstname = Site::obtain_post('register_firstname');
        $this->user->user_lastname = Site::obtain_post('register_lastname');
        $this->user->user_sex = Site::obtain_post('register_sex');
        $this->user->user_address = Site::obtain_post('myAddress');
        $this->user->user_email = Site::obtain_post('register_email');
        $this->user->user_phone = Site::obtain_post('register_phone');
        $this->user->user_phone_hide = 0;
        $this->user->user_godfather = Site::obtain_post('register_godfather');
        $this->user->user_password = Site::obtain_post('register_password1');
        $this->user->user_active = true;
        $this->user->user_rank = 1;
        $this->user->user_notation = 0;
        $this->user->user_nb_notation = 0;
        $this->user->user_score = 0;
        $this->user->user_admin = 0;
        $this->user->user_date_creation = date('Y-m-d H:i:s');
        $this->user->user_online = date('Y-m-d H:i:s');
        $this->user->user_birthdate = new \DateTime(Site::obtain_post('register_birthdate'));
        $this->user->user_codepromo = Site::obtain_post('register_codepromo');
        $this->user->user_avatar = Site::obtain_post('avatar');
    }

    private function create()
    {
        $this->init();
        if ($this->getRequestMethod() == 'POST') {
            if (!($errors = $this->user->isValid())) {
                $this->user->save();

                //Retirer la session Facebook
                unset($_SESSION['fb_action']);
                unset($_SESSION['fb_id']);
                unset($_SESSION['fb_name']);
                unset($_SESSION['fb_profile_picture']);

                //Ne pas afficher la vue par défaut
                $display_default = false;

                //Préparer la connexion de l'utilisateur
                $_SESSION['register_email'] = $this->user->user_email;

                $action = new \listener\subject\action($this);
                $action->attach(new \listener\observer\mail());
                $action->attach(new \listener\observer\success());
                $action->notify();

                \Site::message_info('compte créé, veuillez vous rendre sur votre boîte mail pour activer votre compte !','INFO');
                \Site::redirect5sec(WEBDIR);
            } else {
                throw new \Exception(sprintf("Fail to validate registration. %s", addslashes(json_encode($errors))));
            }
        }
    }


    private function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function activateAccount() {
        $token = $_GET['active'];
        $query = \DB::SqlOne("Select * from user where user_active ='".$token."' ");

        if(count($query) == 1){

            $req = \DB::getInstance()->getPDO()->prepare("UPDATE user SET user_active = 1 WHERE user_active = '".$token."' ");
            $req->execute();

            Site::message('compte activé','INFO');
            Site::redirect5Sec(WEBDIR);
        }else{
            Site::message('compte déjà activé','WARNING');
            Site::redirect5Sec(WEBDIR);
        }
    }

    public function sendActivationMail()
    {
        require_once(__DIR__ . '/../lib/mailjet/mailjet.class.php');
        $mailer = new \Mailjet();
        $params = array(
            "method" => "POST",
            "from" => "noreply@mutum.fr",
            "to" => $this->user->user_email,
            "subject" => "Activation du compte",
            "text" => "Pour activer votre compte Mutum, cliquez sur ce lien: http://" . WEBDIR . "/register/activate"
        );

        $result = $mailer->sendEmail($params);

        if ($mailer->_response_code != 200) {
            throw new \RuntimeException($result);
        }

        return true;
    }

}