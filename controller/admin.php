<?php

$action = new adminController();

class adminController
{
    public function __construct()
    {
        $this->route();
    }


    public function route()
    {
        if (isset($_GET['module']) && isset($_GET['action'])) {
            $method = sprintf(
                "%s%sAction",
                strtolower($_GET['module']),
                ucfirst(strtolower($_GET['action']))
            );
            if (method_exists($this, $method)) {
                call_user_func(array($this, $method));
            }
        }
    }

    protected function communityListAction()
    {
        if($this->isMethod('POST')) {
            if(sizeof($_POST['community']) > 4){
                Site::message('Vous ne pouvez avoir que quatre communautés au maximum','WARNING');
            }else{
                join_community::setUserCommunities(Session::Me(), $_POST['community']);
            }

            Site::redirect5sec(WEBDIR . 'community');
        }

        if (isset($_GET['search_community']) || !empty($_GET['search_community'])) {
            $search_community = $_GET['search_community'];
            $results = community::searchCommunity($_GET['search_community']);
        } else {
            $search_community = '';
            $results = array();
        }

        include(Site::include_view('communityList'));
    }


    protected function communityAddAction()
    {
        if ($this->isMethod('POST')) {
            if (community::findByName(Site::obtain_post('comm_name'))) {
                throw new \InvalidArgumentException(
                    sprintf("'%s' community already exists", Site::obtain_post('comm_name'))
                );
            }

            $category = community_cat::getById(Site::obtain_post('comm_cat'));
            if ($category) {
                $category = $category[0][0];
            }

            $address = new address();
            $address->setAttr('id', $address->checkAddr(Site::obtain_post('comm_address')));
            if (!$address->getAttr('id')) {
                $address->initWithString(Site::obtain_post('comm_address'));
                $address->setAttr('id', $address->Insert());
            }

            $community = new community();
            $community->comm_cat = $category->getAttr('id');
            $community->comm_name = Site::obtain_post('comm_name');
            $community->comm_desc = Site::obtain_post('comm_desc');
            $community->comm_address = $address->getAttr('id');
            $community->comm_type = '';
            $community->comm_type_data = '';

//            var_dump($community); die;
            $community->Insert();
        }

        include(Site::include_view('communityAdd'));
    }

    protected function isMethod($method)
    {
        return $_SERVER['REQUEST_METHOD'] == $method;
    }

    protected function getNumberOfComm(){
        return DB::SqlLine("Select count(join_comm_id) from join_community where join_user_id = '".Session::Me()->getAttr('id')."'");
    }
}