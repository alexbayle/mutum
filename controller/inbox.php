<?php
    if(Session::Online() == true) {
        $myId = Session::Me()->getAttr('id') ;


        if (isset($_GET['search_discussion']) && !empty($_GET['search_discussion'])) {
            $search_discussion = $_GET['search_discussion'];
            $results = discussion::searchDiscu($search_discussion);
        } else {
            $search_discussion = '';
            $results = array();
        }


        // Requêtes
        $contacts = contact::seeAllContact() ;
        $discussions = discussion::myDisccuss();
        $nbDiscu = count($discussions);
        $listeDiscu = discussion::listDiscuss();
        
        include(Site::include_view('inbox')) ;
    } else {
        // Redirection vers la page de login
        Site::redirect(WEBDIR.'login') ;
        Site::message_info('Cette page requiert la connexion à un compte.', 'ERROR') ;
        
        // Mise en session de l'url actuelle
        Site::setNextUrl() ;
    }
?>