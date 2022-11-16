<?php
    require_once __DIR__ . '/user.php';
    require_once __DIR__ . '/data.php';
    $error_login; 
    $error_password;
    $error_flag = false;
    $data = new Data();
    $users = $data->read();
    $login = htmlentities(trim($_POST['login_1']));
    $password = htmlentities(trim($_POST['password_1']));
    foreach($users as $user){
        if($user['login'] == $login){
            if($user['password'] == sha1($password . User::$sault)){
                $error_flag = false;
                $user_auto = new User();
                $user_auto->login = $user['login'];
                $user_auto->email = $user['email'];
                $user_auto->name = $user['name'];
                setcookie('login', $user_auto->login, time()+60*60*24*30, "/");
                session_start();
                $_SESSION['login'] = $user_auto->login;
                break;
            } else{
                $error_flag = true;
                $error_password = 'Неверный пароль!';
                $errors = ['flag_error'=>$error_flag,'error_login'=>false,'error_password'=>$error_password];
                break;
            }
        } else{
            $error_flag = true;
            $error_login = 'Данный пользователь не зарегистрирован!';
            $errors = ['flag_error'=>$error_flag, 'error_login'=>$error_login, 'error_password'=>false];
        }
    }
    if($error_flag){
        exit(json_encode($errors));
    } else{
        exit(json_encode($user_auto));
    }
?>