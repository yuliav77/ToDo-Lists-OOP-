<?php

namespace src\models;

class ToDoList extends Element implements ElementInterface
{
    const TABLE = 'lists';

    private $userId;
    private $tasks;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    /** Get all tasks of ToDo List */

    public function setTasks()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName('tasks')
            ->select(['id', 'title', 'is_done', 'list_id'])
            ->where('list_id', $this->getId(), '=')
            ->execute($this->conn);
        $this->tasks = $queryResult;
    }

    public function getTasks()
    {
        return $this->tasks;
    }

    /** Create a ToDo List */

    public function create()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName(self::TABLE)
            ->insert(['title', 'user_id'], [$this->getTitle(), $this->userId])
            ->execute($this->conn);
        $this->setId($queryResult);
        return $queryResult;
    }
}