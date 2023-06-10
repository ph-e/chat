<?php

class Users
{
    private array $users;

    public function __construct() {
        $this->users = [];
    }

    public function addUser(string $token, string $name) : void{
        $this->users[$token] = $name;
    }

    public function getUser() : array{
        return $this->users;
    }

    public function deleteUser(string $token) : void{
        if(array_key_exists($token, $this->users)){
            unset($this->users[$token]);
        }
    }

    public function getName(string $token) : string{
        return $this->users[$token];
    }

}