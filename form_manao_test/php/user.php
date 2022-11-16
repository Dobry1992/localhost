<?php

class User{
    static public $sault = "12345";
    public $login, $password, $email, $name;
    public $login_error, $confirm_error, $password_error, $email_error, $name_error, $errors, $flag_error = false;

    private function validate(){
        //проверка логина
        if(isset($_POST["login"]) && (strlen($_POST["login"]) >= 6)){
            if(trim($_POST['login'])){
                    $json = file_get_contents('../data/db.json');
                    $users = json_decode($json, true);
                    foreach($users as $user){
                        if($user["login"] == $_POST["login"]){
                            $this->flag_error = true;
                            $this->login_error .= 'Login зарегистрирован!<br/>';
                        } else {
                            $this->login = trim(htmlentities($_POST["login"]));
                        }
                    }
            } else{
                $this->login_error .= 'Login не может состоять только из пробелов!<br/>';
                $this->flag_error = true;
            }
        } else {
            $this->login_error .= 'Login должен состоять из более 6 символов!<br/>';
            $this->flag_error = true;
        }
        //проверка пароля
        if(isset($_POST["password"]) && (strlen($_POST["password"]) >= 6)){
            if(trim($_POST['password'])){
                if(preg_match('/^(?=.*[a-z])(?=.*\d)[a-z\d]{6,}$/', $_POST['password'])){
                    if($_POST['password'] == $_POST['confirm_password']){
                        $this->password = htmlentities($_POST["password"]);
                    } else{
                        $this->flag_error = true;
                        $this->confirm_error .= 'Пароль не подтверждён!<br/>'; 
                    }
                } else{
                    $this->flag_error = true;
                    $this->password_error .= 'Пароль должен состоять из цифр и букв!<br/>';
                }
            } else{
                $this->flag_error = true;
                $this->password_error .= 'Пароль не может состоять только из пробелов!<br/>';
            }
        } else{
            $this->flag_error = true;
            $this->password_error .= 'Пароль должен состоять из более 6 символов!<br/>';
        }
        //проверка email
        if($_POST["email"]){
            if(preg_match('/\w+@\w+\.\w+/', $_POST['email'])){
                $json = file_get_contents('../data/db.json');
                $users = json_decode($json, true);
                foreach($users as $user){
                    if($user["email"] == $_POST["email"]){
                        $this->flag_error = true;
                        $this->email_error .= 'Email зарегистрирован!<br/>';
                    } else {
                        $this->email = trim(htmlentities($_POST['email']));
                    }
                }
            } else {
                $this->flag_error = true;
                $this->email_error .= 'Неверный формат email!<br/>';
            }
        } else{
            $this->flag_error = true;
            $this->email_error .= 'Заполните поле email!<br/>';
        }
        //проверка имени
        if($_POST["name"]){
            if(preg_match('/\w{2,}/', $_POST['name'])){
                $this->name = trim(htmlentities($_POST['name']));
            } else{
                $this->flag_error = true;
                $this->name_error .= 'Имя состоит из не менее двух букв!<br/>';
            }
        } else{
            $this->flag_error = true;
            $this->name_error .= 'Введите имя!<br/>';
        }
        return $this->errors = ['flag_error' => $this->flag_error,'login_error' => $this->login_error, 'password_error' => $this->password_error,'email_error' => $this->email_error,'name_error' => $this->name_error, 'confirm_error' => $this->confirm_error];
    }

    function load(){
        $errors = $this->validate();
        if($this->flag_error){
            $res = $errors;
        } else{
            $password_hash = sha1($this->password . User::$sault);
            $res = ['login' => $this->login, 'password' => $password_hash,'email' => $this->email,'name' => $this->name, 'flag_error' => $this->flag_error];
        }
        return $res;
    }
}

?>