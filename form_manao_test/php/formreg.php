<?php
    require_once __DIR__ . '/user.php';
    require_once __DIR__ . '/data.php';
    $user = new User();
    $data = new Data();
    $jsonData = $user->load();
    if($user->flag_error){
        exit(json_encode($jsonData, JSON_FORCE_OBJECT));
    } else{
        $data->create($jsonData);
    }
?>