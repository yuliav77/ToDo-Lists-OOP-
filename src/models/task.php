<?php

namespace src\models;

class Task extends Element implements ElementInterface
{
    const TABLE = 'tasks';

    private $isDone;
    private $listId;

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

    /** Create a Task */

    public function create()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName(self::TABLE)
            ->insert(['title', 'list_id'], [$this->getTitle(), $this->listId])
            ->execute($this->conn);
        $this->setId($queryResult);
        return $queryResult;
    }

    /** Delete Task */

    public function delete()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName(self::TABLE)
            ->delete()
            ->where('id', $this->getId(), '=')
            ->execute($this->conn);
        return $queryResult;
    }

    /** Change 'Is Done' mark */

    public function mark()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName(self::TABLE)
            ->update('is_done', $this->getIsDone())
            ->where('id', $this->getId(), '=')
            ->execute($this->conn);
        return $queryResult;
    }
}