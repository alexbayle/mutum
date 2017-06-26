<?php
    $disc_id = Site::obtain_post('disc_id') ;
    $invites = Site::obtain_post('invites') ;
    
    $sp = substr($invites, 0, -1) ;
    $speakers = explode('-', $sp) ;
    foreach($speakers as $s) {
        $spea_id = intval($s) ;
        speakers::AddToUserDiscussion($disc_id, $spea_id) ;
    }
?>