<?php
use Workerman\Worker;

require_once __DIR__ . '/init.php';


$users = new Users();

$worker = new Worker('websocket://0.0.0.0:2356');

$worker->count = 4;

$worker->onConnect = function ($c){
    $c->token = uniqid();
};

$worker->onMessage = function ($connection, $request) use ($worker) {
    global $users;
    $request = json_decode($request, true);
    $function = strval($request['functionName']);
    if($function === 'authorizationCheck'){
        $connection->send(json_encode($users->getName($connection->token)));
    }
    else if($function === 'sendMessage'){
        sendMessage($request['message'], $users->getName($connection->token));
        $response = ['functionName' => 'updateMessage','messages' => ['text' => $request['message'], 'name' => $users->getName($connection->token)]];
        $us = $users->getUser();
        foreach ($worker->connections as $con) {
            if (isset($us[$con->token])) {
                $con->send(json_encode($response));
            }
        }
    }
    else if($function === 'connect'){
        $connection->token = $request['token'];
        $function = 'addUser';
        $response = ['functionName' => 'getMessages', 'messages' => getMessages()];
        $connection->send(json_encode($response));
    }
    else if($function === 'signUP'){
        $response = ['functionName' => 'authorizationCheck', 'err' => '', 'token' => $connection->token];
        if(!signUP($request['name'],$request['password'],$connection->token)){
            $response ['err'] = 'Name is taken';
        }
        $connection->send(json_encode($response));
    }
    else if($function === 'signIN'){
        $response = ['functionName' => 'authorizationCheck', 'err' => '', 'token' => signIN($request['name'],$request['password'])];
        if($response['token'] === ''){
            $response ['err'] = 'Username or password entered incorrectly';
        }
        $connection->send(json_encode($response));

    }
    if($function === 'addUser') {
        $users->addUser($connection->token, getNameDB($connection->token));
        $response = ['functionName' => 'updateUserList', 'name' => $users->getUser()];
        $us = $users->getUser();
        foreach ($worker->connections as $con) {
            if (isset($us[$con->token])) {
                $con->send(json_encode($response));
            }
        }
    }
};

$worker->onClose = function ($c) use ($worker) {
    global $users;
    $us = $users->getUser();
    if(isset($us[$c->token])){
        $users->deleteUser($c->token);
        $response = ['functionName' => 'updateUserList', 'name' => $users->getUser()];
        foreach ($worker->connections as $con) {
            if (isset($us[$con->token])) {
                $con->send(json_encode($response));
            }
        }
    }
};

$worker::runAll();