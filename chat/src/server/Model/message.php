<?php
require_once 'Database.php';

$db = new Database();

function sendMessage(string $text, string $name) : void{
    global $db;
    try{
        $sql = "INSERT INTO message (text, user_id) SELECT :text, id FROM user WHERE user.name = :name";
        $params = ['text' => htmlspecialchars($text), 'name' => htmlspecialchars($name)];
        $db->query($sql,$params);
    }catch (Exception $exception){
        echo "\nError: " . $exception;
    }
}

function getMessages() : array {
    global $db;
    try {
        $sql = "SELECT message.id, message.text, user.name FROM message JOIN user ON message.user_id = user.id ORDER BY message.id ASC";
        return $db->query($sql,[])->fetchAll(PDO::FETCH_ASSOC);
    }catch (Exception $exception){
        echo "\nError: " . $exception;
    }
}

/*
 * В дальнейшем можно дополнить удалением и редактированием сообщений
 * */