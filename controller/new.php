<?php

namespace Controller;

use Mutum\Bundle\V2Bundle\Entity\LimitationField;
use \Site;

if (!\Session::online()) {
    \Site::redirect(WEBDIR);
}


$object = new NewController();
$article = $object->getArticle();

include(Site::include_view('new'));


class NewController
{
    private $article;

    public function __construct()
    {
        try {
           $this->newArticleFactory();

        } catch (\Exception $e) {
            \Site::message($e->getMessage(), 'ERROR');
        }
    }

    public function getArticle()
    {

        return $this->article;
    }

    private function newArticleFactory()
    {
        if (isset($_GET['module'])) {
            switch ($_GET['module']) {
                case 'wish':
                    if (isset($_GET['action'])) {
//                        if (isset($_GET['arti_prod_id'])) {
//                            return $this->editWish($_GET['action']);
//                        }

                        $this->createWish($_GET['action']);
                    }
                    break;
                default:
                    throw new \Exception('To implement');
            }
        } else {
            $this->create();
        }
    }

    private function createWish($wishPostId)
    {
        $this->initWish($wishPostId);

        if ($this->getRequestMethod() == 'POST') {
            if ($errors = $this->article->isValid()) {
                $this->article->arti_pictures = json_encode($this->article->arti_pictures);
                $this->article->save();

                \Site::redirect('/');
            } else {
                var_dump($errors);
                throw new \Exception('Fail to validate article');
            }
        }
    }

    private function editWish($wishPostId)
    {
        $this->initWish($wishPostId);
    }

    private function initWish($wishPostId)
    {
        $virtualArticle = \wishlist::getByIdWithRelations($wishPostId);
        $this->init();
        $this->article->prod_user_id = \Session::Me()->user_id;
        $this->article->prod_name = \Site::obtain_post('art_name') ?: $virtualArticle['virp_name'];
        $this->article->prod_desc = \Site::obtain_post('art_desc') ?: $virtualArticle['wish_desc'];
        $this->article->art_desc = \Site::obtain_post('art_desc') ?: $virtualArticle['wish_desc'];
        $this->article->arti_dates = \Site::obtain_post('art_dates') ?: $virtualArticle['wish_date'];
    }

    private function init()
    {
        $this->article = new \article;
        $this->article->prod_name = \Site::obtain_post('art_name');
        $this->article->prod_desc = addslashes(\Site::obtain_post('art_desc'));
        $this->article->prod_limitation = 0;
        $this->article->prod_nb_notation = 0;
        $this->article->prod_notation = 0;
        $this->article->arti_dispo = 1;
        $this->article->prod_date_creation = date('Y-m-d H:i:s');
        $this->article->prod_deleted = 0;
        $catId = (\Site::obtain_post('art_cat_id3')) ?:
            (\Site::obtain_post('art_cat_id2')) ?:
            (\Site::obtain_post('art_cat_id1'));
        $this->article->arti_cat = $catId;
        $this->article->art_desc = \Site::obtain_post('art_desc');
        $this->article->arti_price = \Site::obtain_post('art_price');
        $this->article->arti_length = \Site::obtain_post('arti_length');
        $this->article->arti_caution = \Site::obtain_post('art_caution');
        $this->article->art_address = \Site::obtain_post('full_address_1');
        $this->article->arti_state = \Site::obtain_post('arti_state');

        $dates = \Site::obtain_post('art_dates');
        $dates = explode(', ', $dates);
        $this->article->arti_dates = json_encode($dates);



//        $article->arti_pictures = json_encode();
        if (\Site::obtain_post('image_1') || \Site::obtain_post('image_2') || \Site::obtain_post('image_3')) {
            $this->article->arti_pictures = array(
                \Site::obtain_post('image_1'),
                \Site::obtain_post('image_2'),
                \Site::obtain_post('image_3'),
            );
        }

        $this->article->prod_user_id = \Session::Me()->user_id;

        $art_win = 0;

        if (Site::obtain_post('art_name') != "")
            $art_win += 1;
        if ($catId != "")
            $art_win += 1;
        if (Site::obtain_post('art_price') > "0")
            $art_win += 1;
        if (\Site::obtain_post('image_1')!='' || \Site::obtain_post('image_2')!='' || \Site::obtain_post('image_3')!='')
            $art_win += 3;
        if (Site::obtain_post('arti_state') != "")
            $art_win += 1;
        if (Site::obtain_post('art_desc') != "")
            $art_win += min(4,floor((sizeof(preg_split('/\b\w+\b/',Site::obtain_post('art_desc')))-1)/6));
        if (Site::obtain_post('full_address_1') != "")
            $art_win += 1;

        $this->article->prod_win = $art_win;
    }

    private function create()
    {
        $this->init();
        if ($this->getRequestMethod() == 'POST') {
            if ($errors =$this->article->isValid()) {
                $this->article->save();


                $user = \Session::Me();
                $user->addCredit($this->article->prod_win);
                $user->addScore($this->article->prod_win);
                $user->Update();

                $action = new \listener\subject\action($this);
                //$action->attach(new \listener\observer\history());
                $action->attach(new \listener\observer\history($this->article->prod_win));
                $action->attach(new \listener\observer\success());
                $action->notify();


                // manage communities relationships
                $tabcomm = \Site::obtain_post('communities');
                $communities = explode(',',$tabcomm);
                if($communities[0]=='') $communities=array();
                foreach ($communities as $communityId) {
                    $community = \community::getById($communityId);
                    if ($community) {
                        $community = $community[0][0];
                        $this->article->addCommunity($community);
                    }
                }

                // manage communities posts
                $post = new \post();
                $post->post_user_id = \Session::Me()->getAttr('id');
                $post->post_text = $this->article->prod_name;
                $post->post_cat = 2; // new_article
                $post->post_date_creation = $this->article->prod_date_creation;
                $post->post_deleted = false;
                $postId = $post->Insert();




                foreach ($communities as $community) {
                    $community = \community::getById($community);
                    $limitation = new \limitation();
                    $limitation->limi_post_id = $postId;
                    $limitation->limi_id = $limitation->Insert();

                    $limitationField = new \limitation_field();
                    $limitationField->limf_table_id = $community[0][0]->getAttr('id');
                    $limitationField->limf_type = 2;
                    $limitationField->limf_limi_id = $limitation->limi_id;
                    //var_dump($limitationField);
                    $limitationField->Insert();
                }
                \Site::message('votre objet a bien été ajouté !','INFO');
                \Site::redirect5Sec('/');
            } else {
                Site::message_info($errors,'ERROR');
                throw new \Exception('Fail to validate article');
            }
        }
    }


    private function edit($id)
    {


    }

    private function show($id)
    {

    }

    private function mutumWin(){

        $prod_win = \DB::SqlLine('select prod_win from product where ');
    }

    private function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}