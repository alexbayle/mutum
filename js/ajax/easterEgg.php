<?php


    $easterEggIndex = 4000 + \Site::obtain_post('easterEggIndex');
    $userId = \Session::Me()->getAttr('id');

    \DB::SqlLine("INSERT INTO mutum_v2.success_achievements (suca_user_id, suca_achi_id, created_at) VALUES ('"."$userId"."','".$easterEggIndex."', now())");

?>