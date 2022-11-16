<?php

$fields = [
    'login' =>[
        'field_name' => 'Login',
        'requiered' => 1,
    ],
    'password' =>[
        'field_name' => 'Password',
        'requiered' => 1,
    ],
    'confirm_password' =>[
        'field_name' => 'Confirm password',
        'requiered' => 1,
    ],
    'email' =>[
        'field_name' => 'Email',
        'requiered' => 1,
    ],
    'name' =>[
        'field_name' => 'Name',
        'requiered' => 1,
    ],
];

function load($data){
    foreach($_POST as $key => $value){
        if(array_key_exists($key, $data)){
            $data[$key]['value'] = htmlentities(trim($value));
        }
    }
    return $data;
}

function validate($data){
    $errors = '';
    foreach($data as $key => $value){
        if($data[$key]['requiered'] && empty($data[$key]['value'])){
            $errors .= "<li>Вы не заполнили поле {$data[$key]['field_name']}<li>";
        }
    }
    if($data['password']['value'] != $data['confirm_password']['value']){
        $errors .= "<li>Пароль не подтвержден!</li>";
    }
    $xml = simplexml_load_file('../data/db.xml');
    foreach($xml as $user){
        if($user->login == $data['login']['value']){
            $errors .= "<li>Введенный Вами логин занят!</li>";
        }
        if($user->email == $data['email']['value']){
            $errors .= "<li>Введенный Вами адрес электронной почты занят!</li>";
        }
    }
    return $errors;
}

function saveDbXML($data){
    $xml = simplexml_load_file('../data/db.xml');
    $user_xml = $xml -> addChild('user');
    $sault = "12345";
    $pasCript = sha1($data['password']['value'] . $sault);
    $user_xml->addChild('login', $data['login']['value']);
    $user_xml->addChild('password', $pasCript);
    $user_xml->addChild('email', $data['email']['value']);
    $user_xml->addChild('name', $data['name']['value']);
    $xml->asXML('../data/db.xml');
}

if (!empty($_POST)){
    $fields = load($fields);
    if($errors = validate($fields)){
        $res = ['answer' => 'error', 'errors' => $errors];
    } else {
        $res = ['answer' => 'ok', 'data' => $fields, 'errors' => $errors];
        saveDbXML($fields);
    }
    exit(json_encode($res));
}

?>