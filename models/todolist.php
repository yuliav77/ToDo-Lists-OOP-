<?php

namespace models;

class ToDoList
{
    private $conn;
    private $tableName = "lists";

    public $id;
    public $title;
    public $createdAt;
    public $userId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create ()
    {
        $query = "INSERT INTO " . $this->tableName . " (title, user_id) VALUES (:listTitle, :userId)";
        $sth = $this->conn->prepare($query);
        $sth->bindValue(':listTitle', $this->title);
        $sth->bindValue(':userId', $this->userId);
        if ($sth->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        } else {
            return false;
        }
    }

    public function readAllListsOfUser ()
    {
        $query = "SELECT id, title, user_id FROM " . $this->tableName . " WHERE user_id = :userId";
        $sth = $this->conn->prepare($query);
        $sth->setFetchMode(\PDO::FETCH_ASSOC);
        $sth->bindValue(':userId', $this->userId);
        if ($sth->execute()) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }
}