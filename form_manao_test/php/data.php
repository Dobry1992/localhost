<?php

class Data{
    function create($data){
        if(file_exists('../data/db.json')){
            $json = file_get_contents('../data/db.json');
            $jsonData = json_decode($json, true);
            if($jsonData){
                $jsonData[] =$data;
                file_put_contents('../data/db.json', json_encode($jsonData, JSON_FORCE_OBJECT));
                exit(json_encode($jsonData, JSON_FORCE_OBJECT));
            } else {
                file_put_contents('../data/db.json', json_encode([$data], JSON_FORCE_OBJECT));
                exit(json_encode(([$data]), JSON_FORCE_OBJECT));
            }
        }
    }

    function read(){
        if(file_exists('../data/db.json')){
            $json = file_get_contents('../data/db.json');
            $jsonData = json_decode($json, true);
            return $jsonData;
        }
    }

    function update($login, $key, $value){
        if(file_exists('../data/db.json')){
            $json = file_get_contents('../data/db.json');
            $jsonData = json_decode($json, true);
            foreach($jsonData as $user){
                if($user['login'] == $login){
                    $user[$key] = $value;
                } 
            }
            file_put_contents('../data/db.json', json_encode($jsonData, JSON_FORCE_OBJECT));
            exit(json_encode($jsonData, JSON_FORCE_OBJECT));
        }
    }

    function delete($login){
        if(file_exists('../data/db.json')){
            $json = file_get_contents('../data/db.json');
            $jsonData = json_decode($json, true);
            foreach($jsonData as $user){
                if($user['login'] == $login){
                    unset($user);
                }
            }
            file_put_contents('../data/db.json', json_encode($jsonData, JSON_FORCE_OBJECT));
            exit(json_encode($jsonData, JSON_FORCE_OBJECT));
        }
    }
}

?>
