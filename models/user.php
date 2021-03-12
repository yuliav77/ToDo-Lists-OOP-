<?php

class User
{
    private $conn;
    private $tableName = "users";

    public $id;
    public $name;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create ()
    {
        $query = "INSERT INTO " . $this->tableName . " (name, password) VALUES (:name, :password)";
        $sth = $this->conn->prepare($query);
        $sth->bindValue(':name', $this->name);
        $sth->bindValue(':password', $this->password);
        if ($sth->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        } else {
            return false;
        }
    }

    public function checkIfUserExistsWithName()
    {
        $query = "SELECT id, name, password FROM "  . $this->tableName . " WHERE name = :name";
        $sth = $this->conn->prepare($query);
        $sth->setFetchMode(\PDO::FETCH_ASSOC);
        $sth->bindValue(':name', $this->name);
        if ($sth->execute()) {
            return $sth->fetch();
        } else {
            return false;
        }
    }

    public function checkIfUserExistsWithNameAndPassword ()
    {
        $query = "SELECT id, name, password FROM "  . $this->tableName . " WHERE name = :name AND password = :password";
        $sth = $this->conn->prepare($query);
        $sth->setFetchMode(\PDO::FETCH_ASSOC);
        $sth->bindValue(':name', $this->name);
        $sth->bindValue(':password', $this->password);
        if ($sth->execute()) {
            $existingUser = $sth->fetch();
            return $existingUser['id'];
        } else {
            return false;
        }
    }

}