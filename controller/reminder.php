<?php
namespace Controller;

use \Site;

if(\Session::Online())
{
    Site::message_info('vous ne pouvez pas accéder à cette page en étant connecté, vous l\'êtes déjà.','WARNING');
    Site::redirect(WEBDIR);
    exit();
}

$object = new reminderController();

class reminderController
{
    public function __construct()
    {
        try {
            $this->reminderFactory();
        } catch (\Exception $e) {
            \Site::message($e->getMessage(), 'ERROR');
        }
    }


    private function reminderFactory()
    {
        if (isset($_GET['module']) && !empty($_GET['module'])) {
            $module = $_GET['module'];
            switch ($module) {
                case 'forget':
                    $this->forgetAction();
                    $this->init();
                    break;
                case 'update':
                    $this->update();
                    break;
            }
        } else {
            Site::redirect(WEBDIR . 'reminder/forget');
        }
    }

    private function forgetAction()
    {
        include(Site::include_view('forget'));
    }

    private function updateAction()
    {
        include(Site::include_view('update'));
    }

    public function init()
    {
        $valid = Site::obtain_post('envoyer');

        if($valid != '')
        {
            $email = Site::obtain_post('email');
            $query = \DB::SqlOne("Select * from user where user_email ='".$email."' ");
            $exist = count($query) == 1;

            if($exist)
            {
                $token = md5(uniqid(rand(), true));

                $req = \DB::getInstance()->getPDO()->prepare("UPDATE user SET user_token = '".$token."' WHERE user_email = '".$email."' ");
                $req->execute();

                $this->sendForgetPassMail($email,$token);
                Site::message('email envoyé à votre adresse','INFO');
                Site::redirect5Sec(WEBDIR);
            }
            else
            {
                Site::message('cet e-mail n\'existe pas','WARNING');
            }
        }else{

        }

    }


    public function sendForgetPassMail($mail,$lien)
    {
        require_once(__DIR__ . '/../lib/mailjet/mailjet.class.php');
        $mailer = new \Mailjet();
        $params = array(
            "method" => "POST",
            "from" => "mutum.fr <noreply@mutum.fr>",
            "to" => $mail,
            "subject" => "Changement de mot de passe",
            "html" => "Pour changer votre mot de passe veuillez cliquer sur le lien: " . WEBDIR . "reminder/update?token=".$lien.""
        );

        $result = $mailer->sendEmail($params);

        if ($mailer->_response_code != 200) {
            throw new \RuntimeException($result);
        }

        return true;
    }


    private function update()
    {
        $token = $_GET['token'];
        $query = \DB::SqlOne("Select * from user where user_token ='".$token."'");
        if(count($query) == 1){
            $this->updateAction();

            $valid = Site::obtain_post('modif');

            if($valid != '')
            {
                $mdp1 = Site::obtain_post('mdp1');
                $mdp2 = Site::obtain_post('mdp2');
                $error = '';

                if($mdp1 == '' || $mdp2 == '')
                {
                    $error = 'un des deux mots de passe ne sont pas remplis';
                    Site::message_info($error, 'ERROR');
                }
                if($mdp1 != $mdp2)
                {
                    $error = 'les deux mots de passe ne sont pas identiques';
                    Site::message_info($error, 'ERROR');
                }
                else
                {
                    $req = \DB::getInstance()->getPDO()->prepare("UPDATE user SET user_password = '".Site::crypt_pwd($mdp2)."' WHERE user_token = '".$token."' ");
                    $req->execute();
                    Site::message('mot de passe modifié avec succès','INFO');

                }

            }
            else
            {

            }


        }else{
            Site::message('erreur ! vous ne pouvez accéder à cette page qu\'avec le lien envoyé par email','WARNING');
            Site::redirect5Sec(WEBDIR);
        }
    }

}