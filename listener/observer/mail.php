<?php

namespace listener\observer;

use SplSubject;

require_once(__DIR__ . '/../../lib/mailjet/mailjet.class.php');

class mail implements \SplObserver
{
    private $mailTo;

    public function __construct($mailTo = null)
    {
        $this->mailer = new \Mailjet();
//        $this->mailer->debug = 2;

        if ($mailTo) {
            $this->mailTo = $mailTo;
        }
    }


    public function update(SplSubject $action)
    {
        $controller = $action->getParent();
        $klass = get_class($controller);
        switch ($klass) {
            case 'Controller\SponsorController':
                break;
            case 'Controller\RegisterController':
                $text = file_get_contents(__DIR__ . "/../../mails/register/register.html");
                $tab = array(
                    array("code" => "[prenom]", "variable" => $controller->getUser()->getAttr('firstname')),
                    array("code" => "[nom]", "variable" => $controller->getUser()->getAttr('lastname')),
                    array("code" => "[code]", "variable" => $controller->getUser()->getAttr('active')),
                    array("code" => "[url]", "variable" => WEBDIR),
                );
                $text = $this->associate($text, $tab);
                $params = array(
                    'method' => 'post',
                    'subject' => 'Enregistrement',
                    'from' => MAILER_FROM,
                    'to' => $controller->getUser()->user_email,
                    'html' => $text,
                    'inlineattachment' => array(
                        "@".WEBDIR."mails/ressources/mailjet_img1.png",
                        "@".WEBDIR."mails/ressources/mailjet_img2.png"
                    )
                );
                $result = $this->mailer->sendEmail($params);

                return $result;
                break;
            default:
                throw new \Exception(sprintf("Manager for '%s' should be implemented.", $klass));
        }
    }

    public function associate($text, $tab)
    {
        foreach ($tab as $t) {
            $text = str_replace($t['code'], $t['variable'], $text);
        }
        $text = str_replace('[url]', WEBDIR, $text);

        return $text;
    }
}