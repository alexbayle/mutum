<?php
namespace Controller;

use \Site;

$object = new helpController();

class helpController
{

    public function __construct()
    {
        try {
            $this->helpFactory();
        } catch (\Exception $e) {
            \Site::message($e->getMessage(), 'ERROR');
        }
    }

    private function helpFactory()
    {
        if (isset($_GET['module']) && !empty($_GET['module'])) {
            $module = $_GET['module'];
            switch ($module) {
                case 'howitworks':
                    $this->howitworksAction();
                    break;
                case 'faq':
                    $this->faqAction();
                    break;
                case 'contactus':
                    $this->contactusAction();
                    $this->sendEmail();
                    break;
                case 'bug':
                    $this->bugAction();
                    $this->sendEmailWithAttach();
                    break;
            }
        } else {
            Site::redirect(WEBDIR . 'legal/cgu');
        }
    }

    private function howitworksAction()
    {
        include(Site::include_view('howitworks'));
    }

    private function faqAction()
    {
        include(Site::include_view('faq'));
    }

    private function contactusAction()
    {
        include(Site::include_view('contactus'));
    }

    private function bugAction(){
        include(Site::include_view('bug'));
    }

    public function associate($text, $tab)
    {
        foreach ($tab as $t) {
            $text = str_replace($t['code'], $t['variable'], $text);
        }
        $text = str_replace('[url]', WEBDIR, $text);

        return $text;
    }
    private function sendEmail()
    {

        require_once(__DIR__ . '/../lib/mailjet/mailjet.class.php');

        $valid = Site::obtain_post('valid');

        if (isset($valid) && !empty($valid)) {

            $sujet = Site::obtain_post('sujet');
            $mail = Site::obtain_post('mail');
            $msg = Site::obtain_post('msg');

            $text = file_get_contents(__DIR__ . '/../mails/contact/contact.html');
            $mailer = new \Mailjet();

            $tab = array(
                array("code" => "[email]", "variable" => $mail),
                array("code" => "[date]", "variable" => date('Y-m-d')),
                array("code" => "[sujet]", "variable" => $sujet),
                array("code" => "[message]", "variable" => $msg)
            );
            $text = $this->associate($text, $tab);
            $params = array(
                    'method' => 'post',
                    'subject' => 'Contact',
                    'from' => 'mutum.fr <noreply@mutum.fr>',
                    'to' => 'mutum.fr <contact@mutum.fr>',
                    'html' => $text,
                    'inlineattachment' => array(
                        "@".WEBDIR."mails/ressources/mailjet_img1.png",
                        "@".WEBDIR."mails/ressources/mailjet_img2.png"
                    )

            );

            $result = $mailer->sendEmail($params);

            if ($mailer->_response_code != 200) {
                throw new \RuntimeException($mailer);
            }

            Site::message_info('Email envoyé','INFO');
            Site::redirect5Sec(WEBDIR);

            return $result;
        }
    }

    private function sendEmailWithAttach()
    {
        $valid = Site::obtain_post('valid');
        if ($valid) {

            $sujet = Site::obtain_post('sujet');
            $mail = Site::obtain_post('mail');
            $msg = Site::obtain_post('msg');

            $uploaddir = 'attach/';

            $files = array();

            foreach(array('pj1','pj2') as $field){
                if(isset($_FILES[$field]) && $_FILES[$field]['error'] == 0){
                    $filename = strtolower(str_replace(' ','_',basename($_FILES[$field]['name'])));
                    $uploadfile = $uploaddir . $filename;
                    if (move_uploaded_file($_FILES[$field]['tmp_name'], $uploadfile)) {
                        echo "le fichier est valide, et a été téléchargé avec succès. voici plus d'informations :\n";
                    } else {
                        echo "attaque potentielle par téléchargement de fichiers. voici plus d'informations :\n";
                    }
                    $files[] = "@".$uploadfile;
                }
            }


            require_once(__DIR__ . '/../lib/mailjet/mailjet.class.php');
            $text = file_get_contents(__DIR__ . '/../mails/contact/contact.html');
            $mailer = new \Mailjet();

            $tab = array(
                array("code" => "[email]", "variable" => $mail),
                array("code" => "[date]", "variable" => date('Y-m-d')),
                array("code" => "[sujet]", "variable" => $sujet),
                array("code" => "[message]", "variable" => $msg)
            );
            $text = $this->associate($text, $tab);
            $params = array(
                'method' => 'post',
                'subject' => 'Contact',
                'from' => 'mutum.fr <noreply@mutum.fr>',
                'to' => 'mutum.fr <webmaster@mutum.fr>',
                'html' => $text,
                'attachment' => $files,
                'inlineattachment' => array(
                    "@".WEBDIR."mails/ressources/mailjet_img1.png",
                    "@".WEBDIR."mails/ressources/mailjet_img2.png"
                )
            );
            $result = $mailer->sendEmail($params);

            if ($mailer->_response_code != 200) {
                throw new \RuntimeException($mailer);
            }

            Site::message('email envoyé !','INFO');
            //Site::redirect5Sec(WEBDIR);

            return $result;

        }
    }
}

