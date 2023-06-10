<?php

class Database
{
    private ?PDO $db = null;
    public function __construct(){
        if ($this->db === null) {
            $this->db = $this->createConnectionDB();
        }
    }

    private static function createConnectionDB() : PDO{
        return new PDO("mysql:host=localhost;dbname=chat;charset=utf8", "root", "");
    }

    public function query(string $sql, array $params) : PDOStatement{
        $query = $this->db->prepare($sql);
        $query->execute($params);
        return $query;
    }
}