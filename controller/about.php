<?php
namespace Controller;

use \Site;

$object = new aboutController();

class aboutController
{
    public function __construct()
    {
        try {
            $this->aboutFactory();
        } catch (\Exception $e) {
            \Site::message($e->getMessage(), 'ERROR');
        }
    }


    private function aboutFactory()
    {
        if (isset($_GET['module']) && !empty($_GET['module'])) {
            $module = $_GET['module'];
            switch ($module) {
                case 'team':
                    $this->teamAction();
                    break;
                case 'charter':
                    $this->charterAction();
                    break;
                case 'press-kit':
                    $this->pressAction();
                    break;
                case 'speaking-about-us':
                    $this->talkAction();
                    break;
                case 'join-us':
                    $this->joinAction();
                    break;
            }
        } else {
            Site::redirect(WEBDIR . 'about/team');
        }
    }

    private function teamAction()
    {
        include(Site::include_view('team'));
    }

    private function charterAction()
    {
        include(Site::include_view('charter'));
    }

    private function pressAction()
    {
        include(Site::include_view('press-kit'));
    }

    private function joinAction()
    {
        include(Site::include_view('join-us'));
    }

    private function talkAction()
    {
        include(Site::include_view('talking-about-us'));
    }
}