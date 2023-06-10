<?php
require_once 'Database.php';

$db = new Database();
function signUP(string $name, string $password, string $token) : bool{
    global $db;
    $name = htmlspecialchars($name);
    if(!nameIsTaken($name)){
        $sql = "INSERT INTO user(name,password,token) VALUES (:name,:password,:token)";
        /*
        * В реальном проекте я бы конечно хешировал пароль
        * но тут думаю смысла нет:)
        * $hash = password_hash($password, PASSWORD_BCRYPT);
        * */
        $params = ['name' => htmlspecialchars($name), 'password' => htmlspecialchars($password), 'token' => $token];
        $db->query($sql,$params);
    }
    else{
        return false;
    }
    return true;
}

function signIN(string $name, string $password) : string{
    global $db;
    $sql = "SELECT token FROM user WHERE user.name = :name AND user.password = :password";
    $params = ['name' => htmlspecialchars($name), 'password' => htmlspecialchars($password)];
    $query = $db->query($sql,$params);
    return $query->fetchColumn() ?? '';
}


function nameIsTaken(string $name) : bool{
    global $db;
    try {
        $sql = "SELECT * FROM user WHERE name = ?";
        $params = [htmlspecialchars($name)];
        $query = $db->query($sql,$params);
        if ($query->rowCount() > 0){
            return true;
        }
    }catch (Exception $exception){
        echo "\nError: " . $exception;
    }
    return false;
}

function getNameDB(string $token) : string{
    global $db;
    try{
        $sql = "SELECT name FROM user WHERE token = ?";
        $params = [$token];
        return $db->query($sql,$params)->fetchColumn();
    }catch (Exception $exception){
        echo "\nError: " . $exception;
    }
}