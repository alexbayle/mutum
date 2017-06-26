<?php
namespace Controller;

use \Site;
use \DB;

$object = new acceuilController();

class acceuilController
{
    public function __construct()
    {
        try {
            $this->accueilAction();
        } catch (\Exception $e) {
            \Site::message($e->getMessage(), 'ERROR');
        }
    }

    public function accueilAction()
    {
        if(\Session::Online()) {
            $lesMieuxNotés = \article::getLesMieuxNotés();
            $mesObjets = \article::getMesObjets();
            $lesPlusEmpruntés = \article::getLesPlusEmpruntés();
        }
        else{
            $lesPlusEmpruntés = \article::getLesPlusEmpruntés();
            $lesMieuxNotés = \article::getLesMieuxNotés();
        }
        include(Site::include_global('accueil'));
    }
}
?>