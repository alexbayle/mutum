<?php
namespace Controller;

use \Site;

$object = new legalController();

class legalController
{
    public function __construct()
    {
        try {
            $this->legalFactory();
        } catch (\Exception $e) {
            \Site::message($e->getMessage(), 'ERROR');
        }
    }


    private function legalFactory()
    {
        if (isset($_GET['module']) && !empty($_GET['module'])) {
            $module = $_GET['module'];
            switch ($module) {
                case 'cgu':
                    $this->cguAction();
                    break;
                case 'cgv':
                    $this->cgvAction();
                    break;
                case 'legal-notices':
                    $this->legalNoticesAction();
                    break;
            }
        } else {
            Site::redirect(WEBDIR . 'legal/cgu');
        }
    }

    private function cguAction()
    {
        include(Site::include_view('cgu'));
    }

    private function cgvAction()
    {
        include(Site::include_view('cgv'));
    }

    private function legalNoticesAction()
    {
        include(Site::include_view('legal-notices'));
    }
}