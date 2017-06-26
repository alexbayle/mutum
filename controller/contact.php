<?php
    if(Session::Online()) {

        // Variables

        if(isset($_GET['search_user'])) {
            $search_user = $_GET['search_user'];
        }
        else{
            $search_user = '';
        }

        $nbContact = user::totalUser($search_user);
        $nbSearchContact = 10;
        $nbPage = ceil($nbContact / $nbSearchContact);
        $cPage = 1;

        if(isset($_GET['p']) && $_GET['p'] > 1 && $_GET['p'] < $nbPage){
            $cPage = $_GET['p'];
        }else{
            $cPage = 1;
        }

        // Gestion de la recherche
        if(isset($_GET['search_user'])) {
            $search_user = $_GET['search_user'] ;
            $results = user::searchUser($_GET['search_user'],$cPage,$nbSearchContact) ;
        } else {
            $search_user = '' ;
            $results = array() ;
        }

        // Gestion des boutons
        if(isset($_GET['accept_friend'])) {
            contact::acceptFriend($_GET['accept_friend']) ;
            Site::message('Contact ajouté !', 'SUCCESS') ;
        }
        if(isset($_GET['ask_friend'])) {
            if(!contact::checkExistMyAsk($_GET['ask_friend'])) {
                contact::askFriend($_GET['ask_friend']) ;
                Site::message('demande envoyée !', 'SUCCESS') ;
            } else {
                Site::message('demande déjà effectuée !', 'WARNING') ;
            }
        }
        if(isset($_GET['cancel_ask'])) {
            contact::cancelAsk($_GET['cancel_ask']) ;
            Site::message('demande annulée !', 'INFO') ;
        }
        if(isset($_GET['delete_friend'])) {
            contact::deleteFriend($_GET['delete_friend']) ;
            Site::message('contact supprimé !', 'SUCCESS') ;
        }
        if(isset($_GET['delete_ignored'])) {
            contact::deleteIgnored($_GET['delete_ignored']) ;
            Site::message('personne supprimée !', 'SUCCESS') ;
        }
        if(isset($_GET['ignore_friend'])) {
            contact::denyAsk($_GET['ignore_friend']) ;
            Site::message('demande ignorée !', 'INFO') ;
        }


        // Requêtes
        $contacts = contact::seeAllContact() ;
        $waitingAsks = contact::seeWaitingAsks() ;
        $myAsks = contact::seeMyAsks() ;
        $ignored = contact::seeRefused() ;
        
        // Compteurs
        $nbContacts = sizeof($contacts) / 2 ;
        $nbMyAsks = sizeof($myAsks) ;
        $nbIgnored = sizeof($ignored) ;
        $nbMyAskReq = sizeof($waitingAsks);
        
        // Villes
        if($contacts != array()) {
            $cities = array() ;
            foreach($contacts as $c) {
                if($c[0]->getAttr('id') != Session::Me()->getAttr('id')) {
                    $city = user::getCity($c[0]->getAttr('address')) ;
                    if (in_array($city, $cities) == false) {
                        array_push($cities, $city) ;
                    }
                }
            }
            sort($cities) ;
        }
        
        include (Site::include_view("contact")) ;
    } else {
        // Redirection sur la page de login
        Site::redirect(WEBDIR.'login') ;
        Site::message_info('cette page requiert la connexion à un compte','ERROR') ;
        
        // Mise en session de l'url actuelle
        Site::setNextUrl() ;
    }
?>