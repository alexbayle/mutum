<?php

namespace Controller;

use \Site;
use \request;

if (!\Session::online()) {
    Site::redirect(WEBDIR);
}

$object = new LoanController();


class LoanController
{


    public function __construct()
    {
        try {
            $this->loanFactory();
        } catch (\Exception $e) {
            \Site::message($e->getMessage(), 'ERROR');
        }
    }

    private function loanFactory()
    {
        if (isset($_GET['module']) && !empty($_GET['module'])) {
            $module = $_GET['module'];
            switch ($module) {
                case 'emprunt':
                    if (isset($_GET['action'])) {
                        switch ($_GET['action']) {
                            case 'cancel':
                                $this->cancelByBorrower();
                                break;
                            case 'grade':
                                $this->gradeByBorrower();
                                break;
                            case 'archive':
                                $this->archiveBorrow();
                                break;
                            case 'delete':
                                $this->deleteByBorrower();
                                break;
                            case 'signal':
                               $this->signalBorrow();
                        }
                    } else {
                        $this->getLoanEmprunt();
                    }
                    break;
                case 'pret':
                    if (isset($_GET['action'])) {
                        switch ($_GET['action']) {
                            case 'cancel':
                                $this->cancelByLender();
                                break;
                            case 'valid':
                                $this->valid();
                                break;
                            case 'grade':
                                $this->gradeByLender();
                                break;
                            case 'archive':
                                $this->archiveLend();
                                break;
                            case 'delete':
                                $this->deleteByLender();
                                break;
                            case 'signal':
                                $this->signalLend();
                        }
                    } else {
                        $this->getLoanPret();
                    }
                    break;
                case 'archive':
                    $this->getLoanArchive();
                    break;
            }
        } else {
            Site::redirect('loan/emprunt');
        }
    }

    private function getLoanEmprunt()
    {
        $req = new request();
        $req_emprunt = $req->getMyBorrow();
        include(Site::include_view('emprunt'));
    }

    private function getLoanPret()
    {
        $req = new request();
        $req_pret = $req->getMyLend();
        include(Site::include_view('pret'));
    }

    private function getLoanArchive()
    {
        $req = new request;
        $req_archive = $req->getMyArchive();
        include(Site::include_view('archive'));
    }

    private function cancelByBorrower()
    {
        $requId = Site::obtain_post('requ_id');


        $request = request::getById($requId);
        if (!count($request)) {
            return false;
        }

        $article = \article::getCurrentArticle($request[0][0]->requ_prod_id);
        $prix = $article[0][1]->getMutumByDay();
        $date3 = $request[0][0]->requ_date_from;
        $date4 = $request[0][0]->requ_date_to;

        $date1 = new \DateTime($date3);
        $date2 = new \DateTime($date4);

        $result = $date2->diff($date1);
        $result = $result->format('%d');

        $prixTotalMutum = $prix * $result;

        \Site::add_credit_to_user(\Session::Me()->getAttr('id'),$prixTotalMutum,'annulation emprunt');

        $request = $request[0][0];
        $request->requ_status = \request_status::STATUS_CANCEL_BORROWER;
        $request->Update();


        Site::message('vous avez bien annulé votre emprunt','INFO');
        Site::redirect5Sec(WEBDIR . "loan/emprunt");
    }

    private function cancelByLender()
    {
        $requId = \Site::obtain_post('requ_id');
        $text = \Site::obtain_post('txtemprunt');

        $request = \request::getById($requId);
        if (!count($request)) {
            return false;
        }

        $request = $request[0][0];
        $request->requ_status = \request_status::STATUS_CANCEL_LENDER;
        $request->Update();

        $message= new \message;
        $message->setAttr('user_id', \Session::Me()->getAttr('id'));
        $message->setAttr('text', $text);
        $message->setAttr('date_creation', Site::now());
        $message->setAttr('class','');
        $message->setAttr('disc_id',$request->getAttr('discussion'));
        $message->Insert();

        \Site::redirect(WEBDIR . "loan/pret");
    }

    private function valid()
    {
        $requId = \Site::obtain_post('requ_id');

        $request = \request::getById($requId);

        $article = \article::getCurrentArticle($request[0][0]->requ_prod_id);

        $user = \Session::Me();

        if (!count($request)) {
            return false;
        }

        $prix = $article[0][1]->getMutumByDay();
        $date3 = $request[0][0]->requ_date_from;
        $date4 = $request[0][0]->requ_date_to;

        $date1 = new \DateTime($date3);
        $date2 = new \DateTime($date4);

        $result = $date2->diff($date1);
        $result = $result->format('%d');

        $prixTotalMutum = $prix * $result;

        \Site::add_credit_to_user(\Session::Me()->getAttr('id'),$prixTotalMutum,'prêt de ' . $article[0][1]->getAttr('name'));

        $article = $article[0][1];
        $article->arti_dispo = 0;
        $article->Update();

        $request = $request[0][0];
        $request->requ_status = \request_status::STATUS_VALID;
        $request->Update();

        $productInComm = \share_community::findOneByProduct($article->getAttr('prod_id'));
        if($productInComm != array()){
            \post::createFromLoanLender($article,$user,$request);
        }


        \Site::redirect(WEBDIR . "loan/pret");
    }

    private function gradeByLender()
    {
        $requId = \Site::obtain_post('requ_id');
        $text = \Site::obtain_post('txtemprunt');
        $note_emprunteur = \Site::obtain_post('note_emprunteur');
        $title = \Site::obtain_post('title');

        $request = \request::getById($requId);

        $article = \article::getCurrentArticle($request[0][0]->requ_prod_id);

        if (!count($request)) {
            return false;
        }

        $article = $article[0][1];
        $article->arti_dispo = 1;
        $article->Update();

        $request = $request[0][0];


        $notation = new \notation;
        $notation->setAttr('user_id', \Session::Me()->user_id);
        $notation->setAttr('dest_user_id', $request->getAttr('borrower_id'));
        $notation->setAttr('prod_id', $request->getAttr('prod_id'));
        $notation->setAttr('type', 'E');
        $notation->setAttr('date_creation', date('Y-m-d H:i:s'));
        $notation->setAttr('title', $title);
        $notation->setAttr('message', $text);
        $notation->setAttr('note', $note_emprunteur);
        $notationId = $notation->Insert();

        $request->requ_lender_nota_id = $notationId;
        //        $request->requ_status = \request_status::STATUS_RANKED;
        //        $request->Update();
        $request->Update();

        $message= new \message;
        $message->setAttr('user_id', \Session::Me()->getAttr('id'));
        $message->setAttr('text', $text);
        $message->setAttr('date_creation', Site::now());
        $message->setAttr('class','');
        $message->setAttr('disc_id',$request->getAttr('discussion'));
        $message->Insert();

        \Site::redirect(WEBDIR . "loan/pret");
    }

    private function gradeByBorrower()
    {
        $requId = \Site::obtain_post('requ_id');
        $text = \Site::obtain_post('txtemprunt');
        $note_preteur = \Site::obtain_post('note_preteur');
        $note_obj = \Site::obtain_post('note_obj');
        $title = \Site::obtain_post('title');

        $request = \request::getById($requId);
        if (!count($request)) {
            return false;
        }

        $request = $request[0][0];

//        $request->requ_status = \request_status::STATUS_RANKED;
//        $request->Update();

        $notation = new \notation;
        $notation->setAttr('user_id', \Session::Me()->user_id);
        $notation->setAttr('dest_user_id', $request->getAttr('lender_id'));
        $notation->setAttr('prod_id', $request->getAttr('prod_id'));
        $notation->setAttr('type', 'P');
        $notation->setAttr('date_creation', date('Y-m-d H:i:s'));
        $notation->setAttr('title', $title);
        $notation->setAttr('message', $text);
        $notation->setAttr('note', $note_preteur);

        $notationId = $notation->Insert();

        $notationObj = new \notation;
        $notationObj->setAttr('user_id', \Session::Me()->user_id);
        $notationObj->setAttr('dest_user_id', $request->getAttr('lender_id'));
        $notationObj->setAttr('prod_id', $request->getAttr('prod_id'));
        $notationObj->setAttr('type', 'O');
        $notationObj->setAttr('date_creation', date('Y-m-d H:i:s'));
        $notationObj->setAttr('title', $title);
        $notationObj->setAttr('message', $text);
        $notationObj->setAttr('note', $note_obj);
        $notationObj->Insert();

        $request->requ_borrower_nota_id = $notationId;
        $request->requ_prod_note = $note_obj;
        $request->Update();

        $message= new \message;
        $message->setAttr('user_id', \Session::Me()->getAttr('id'));
        $message->setAttr('text', $text);
        $message->setAttr('date_creation', Site::now());
        $message->setAttr('class','');
        $message->setAttr('disc_id',$request->getAttr('discussion'));
        $message->Insert();

        \Site::redirect(WEBDIR . "loan/emprunt");
    }


    private function archiveBorrow()
    {
        $requId = \Site::obtain_post('requ_id');

        $request = \request::getById($requId);
        if (!count($request)) {
            return false;
        }

        $request = $request[0][0];
        $request->requ_borrower_archive = 1;
        $request->Update();

        Site::message('votre emprunt a bien été archivé','INFO');
        Site::redirect5sec(WEBDIR . "loan/archive");
    }

    private function archiveLend()
    {
        $requId = \Site::obtain_post('requ_id');

        $request = \request::getById($requId);
        if (!count($request)) {
            return false;
        }

        $request = $request[0][0];
        $request->requ_lender_archive = 1;
        $request->Update();

        Site::message('votre prêt a bien été archivé','INFO');
        Site::redirect(WEBDIR . "loan/archive");
    }

    private function deleteByLender()
    {
        $requId = \Site::obtain_post('requ_id');

        $request = \request::getById($requId);
        if (!count($request)) {
            return false;
        }

        $article = $request[0][3];
        $article->arti_dispo = 1;
        $article->Update();

        $request = $request[0][0];
        $request->requ_delete = true;
        $request->Update();



        Site::message('votre prêt a bien été supprimé','INFO');
        Site::redirect5sec(WEBDIR . "loan/pret");
    }

    private function deleteByBorrower()
    {
        $requId = \Site::obtain_post('requ_id');

        $request = \request::getById($requId);
        if (!count($request)) {
            return false;
        }

        $request = $request[0][0];
        $request->requ_delete = true;
        $request->Update();

        Site::message('votre emprunt a bien été supprimé','INFO');
        Site::redirect5sec(WEBDIR . "loan/emprunt");
    }

    private function signalBorrow()
    {
       Site::redirect5Sec(WEBDIR. "help/contactus");
    }

    private function signalLend()
    {
        Site::redirect5Sec(WEBDIR. "help/contactus");
    }
}

?>