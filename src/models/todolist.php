<?php

namespace src\models;

class ToDoList extends Element
{
    private $userId;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->tableName = "lists";
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function create ()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName($this->tableName)
            ->insert(["title", "user_id"], [$this->getTitle(), $this->userId])
            ->execute($this->conn);
        $this->setId($queryResult);

        return $queryResult;
    }

    public function readAllListsOfUser ()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName($this->tableName)
            ->select(["id", "title", "user_id"])
            ->where("user_id", $this->userId, "=")
            ->execute($this->conn);

        return $queryResult;
    }
}