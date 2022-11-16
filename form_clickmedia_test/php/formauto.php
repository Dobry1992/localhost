<?php
$sault = "12345";
$fields = [
    'login' =>[
        'field_name' => 'Login',
        'requiered' => 1,
    ],
    'password' =>[
        'field_name' => 'Password',
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
    $flag = false;
    global $sault;
    $xml = simplexml_load_file('../data/db.xml');
    foreach($xml as $user){
        if($user->login == $data['login']['value']){
            $flag = false;
            if(sha1($data['password']['value'] . $sault) != $user->password){
                $errors .= "Неверный пароль!";
                break;
            } 
        } else{
            $flag = true;
        }
    }
    if($flag) $errors .= "Пользователь не зарегистрирован!";
    return $errors;
}

if (!empty($_POST)){
    $fields = load($fields);
    if($errors = validate($fields)){
        $res_1 = ['answer' => 'error', 'errors' => $errors];
    } else {
        $res_1 = ['answer' => 'ok', 'data' => $fields, 'errors' => $errors];
        $xml = simplexml_load_file('../data/db.xml');
        foreach($xml as $user){
            if($user->login == $fields['login']['value']){
                if(sha1($fields['password']['value'] . $sault) == $user->password){
                    setcookie("login", (string)$user->login);
                    session_start();
                    $_SESSION["login"] = (string)$user->login;
                }
            }
        }
    }
    exit(json_encode($res_1));
}

?>