<?php

namespace src\models;

class Task extends Element
{
    private $isDone;
    private $listId;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->tableName = "tasks";
    }

    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;
    }

    public function getIsDone()
    {
        return $this->isDone;
    }

    public function setListId($listId)
    {
        $this->listId = $listId;
    }

    public function getListId()
    {
        return $this->listId;
    }


    public function create ()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName($this->tableName)
            ->insert(["title", "list_id"], [$this->getTitle(), $this->listId])
            ->execute($this->conn);
        $this->setId($queryResult);

        return $queryResult;
    }

    public function readAllTasksOfList()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName($this->tableName)
            ->select(["id", "title", "is_done", "list_id"])
            ->where("list_id", $this->listId, "=")
            ->execute($this->conn);

        return $queryResult;
    }

    public function delete()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName($this->tableName)
            ->delete()
            ->where("id", $this->getId(), "=")
            ->execute($this->conn);

        return $queryResult;
    }

    public function mark()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName($this->tableName)
            ->update("is_done", $this->getIsDone())
            ->where("id", $this->getId(), "=")
            ->execute($this->conn);

        return $queryResult;
    }

}