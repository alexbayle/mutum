<?php

namespace listener\observer;

use SplSubject;

class history implements \SplObserver
{
    private $amount;

    public function __construct($amount = null)
    {
        $this->amount = $amount;
    }

    public function update(SplSubject $action)
    {
        $move = new \move();

        $controller = $action->getParent();
        $klass = get_class($controller);
        switch ($klass) {
            case 'Controller\NewController':
                $move->move_type = "Référencement d'un nouvel objet";
                $move->move_user_id = \Session::Me()->user_id;
                $move->move_article_id = $controller->getArticle()->arti_prod_id;
                break;
            case 'Controller\RegisterController':
                $move->move_type = "Création de compte";
                $move->move_user_id = $controller->getUser()->user_id;
                break;
            default:
                throw new \Exception(sprintf("Manager for '%s' should be implemented.", $klass));
        }

        $move->move_date_creation = date('Y-m-d H:i:s');
        $move->move_amount = $this->amount;
        $move->Insert();
    }
}