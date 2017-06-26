<?php
    $allGrantInvit = Site::obtain_post('all_grant_invit') ;
    $contacts = Site::obtain_post('contacts') ;
    $discName = Site::obtain_post('name') ;
    $message = Site::obtain_post('message') ;
    $myId = Site::obtain_post('myId') ;
    
    // Création de la discussion et récupération de son ID
    discussion::createDiscuss($discName, $allGrantInvit) ;
    $disc_id = DB::LastId() ;
    
    // Enregistrement des speakers
    $speakers = explode('-', $contacts) ;
    foreach($speakers as $s) {
        $spea_id = intval($s) ;
        speakers::AddToUserDiscussion($disc_id, $spea_id) ;
        if($spea_id == $myId) {
            speakers::becomeAdmin($disc_id, $spea_id) ;
            speakers::messageSeen($disc_id, $spea_id) ;
        }
    }
    
    // Enregistrement du message
    $msg = new message() ;
    $msg->setAttr('user_id', $myId) ;
    $msg->setAttr('text', $message) ;
    $msg->setAttr('date_creation', Site::now()) ;
    $msg->setAttr('class', 'text') ;
    $msg->setAttr('disc_id', $disc_id) ;
    $msg->Insert() ;
?>