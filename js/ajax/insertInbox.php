<?php


header('Content-type: application/json');

try {
    $discId = Site::obtain_post('id');
    $message = Site::obtain_post('message');
    $userId = Site::obtain_post('my_id');
    $unMessage = new message;
    $unMessage->setAttr("user_id", $userId);
    $unMessage->setAttr("text", $message);
    $unMessage->setAttr("date_creation", Site::now());
    $unMessage->setAttr("class", "");
    $unMessage->setAttr("disc_id", $discId);
    $unMessage->insert();

    $response = array('success' => true);
} catch (\Exception $e) {
    $response = array('success' => false);
}


die(json_encode($response));
