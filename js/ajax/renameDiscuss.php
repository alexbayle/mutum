<?php
    $discId = Site::obtain_post('disc_id') ;
    $discName = Site::obtain_post('disc_name') ;
    
    discussion::renameDiscuss($discId, $discName) ;
?>