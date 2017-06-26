<?php
    $discId = Site::obtain_post('disc_id') ;
    $newAdminId = Site::obtain_post('new_admin_id') ;
    
    // Suppression de l'ancien admin
    speakers::removeAdmin($discId) ;
    
    // Mise en place du nouvel admin
    speakers::becomeAdmin($discId, $newAdminId) ;
?>