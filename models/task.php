<?php

class Task
{
    private $conn;
    private $tableName = "tasks";

    public $id;
    public $title;
    public $isDone;
    public $createdAt;
    public $listId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create ()
    {
        $query = "INSERT INTO " . $this->tableName . " (title, list_id) VALUES (:task_title, :list_id)";
        $sth = $this->conn->prepare($query);
        $sth->bindValue(':task_title', $this->title);
        $sth->bindValue(':list_id', $this->listId);
        if ($sth->execute()) {
            $this->id = $this->conn->lastInsertId();
            $this->isDone = 0;
            return true;
        } else {
            return false;
        }
    }

    public function readAllTasksOfList()
    {
        $query = "SELECT id, title, is_done AS `done`, list_id FROM " . $this->tableName . " WHERE list_id = :listId";
        $sth = $this->conn->prepare($query);
        $sth->setFetchMode(\PDO::FETCH_ASSOC);
        $sth->bindValue(':listId', $this->listId);
        if ($sth->execute()) {
            return $sth->fetchAll();
        } else {
            return false;
        }
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->tableName . " WHERE id = :id";
        $sth = $this->conn->prepare($query);
        $sth->bindValue(':id', $this->id);
        if ($sth->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function mark()
    {
        $query = "UPDATE " . $this->tableName . " SET is_done = :isDone WHERE id = :id";
        $sth = $this->conn->prepare($query);
        $sth->bindValue(':id', $this->id);
        $sth->bindValue(':isDone', $this->isDone);
        if ($sth->execute()) {
            return true;
        } else {
            return false;
        }
    }

}