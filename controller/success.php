<?php

namespace Controller;

use MangoPay\User;
use \Site;
use Session;

if (!Session::online()) {
    Site::redirect(WEBDIR);
}

$object = new SuccessController();


class SuccessController
{
    private $users;


    public function __construct()
    {
        try {
            $this->successFactory();
        } catch (\Exception $e) {
            \Site::message($e->getMessage(), 'ERROR');
        }
    }

    public function getUsers()
    {
        return $this->users;
    }

    private function successFactory()
    {
        if (isset($_GET['module']) && !empty($_GET['module'])) {
            $module = $_GET['module'];
            switch ($module) {
                case 'ranking':
                    $this->rankingAction();
                    break;
                case 'list':
                    $this->listAction();
                    break;
                case 'wallet':
                    $this->walletAction();
                    break;
            }
        } else {
            Site::redirect(WEBDIR . 'success/ranking');
        }
    }

    private function rankingAction()
    {
        //$users = \user::getList();
        $users = \user::getListUser();
        $ranks = Session::Me()->getScoreRanks();
        include(Site::include_view('ranking'));
    }

    private function listAction()
    {
        $userId = Session::Me()->user_id;
        Session::Me()->getScoreRanks();
        $nbArticles = count(\user::getUserArticle($userId));
        $achievements = \achievements::getAllWithUserStatus($userId);
        $progressBar = (\achievements::getPourcentAchievements()/100*280);
        $easterEggs = \achievements::getEasterEggs();
        $mutumGagnes = \achievements::getMutumAchievements(Session::Me()->getAttr('id'));
        include(Site::include_view('list'));

    }

    private function walletAction()
    {
        $history = \category_article::getCountByUser(Session::Me()->user_id);
        include(Site::include_view('wallet'));
    }

}
