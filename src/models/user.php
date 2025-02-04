<?php

namespace src\models;

class User extends Element implements ElementInterface
{
    const TABLE = 'users';

    private $password;
    private $toDoLists;

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    /** Get user's todo lists with tasks */

    public function setLists()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName('lists')
            ->select(['id', 'title', 'user_id'])
            ->where('user_id', $this->getId(), '=')
            ->execute($this->conn);
        $this->toDoLists = [];
        if ($queryResult) {
            foreach ($queryResult as $list) {
                $todoList = new ToDoList($this->conn);
                $todoList->setId($list['id']);
                $todoList->setTasks();
                $list['tasks'] = $todoList->getTasks();
                $this->toDoLists[] = $list;
            }
        }
    }

    public function getLists()
    {
        return $this->toDoLists;
    }

    /** Create a user */

    public function create()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName(self::TABLE)
            ->insert(['name', 'password'], [$this->getTitle(), $this->password])
            ->execute($this->conn);
        $this->setId($queryResult);
        return $queryResult;
    }

    /** Check If User Exists With Name */

    public function checkIfUserExistsWithName()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName(self::TABLE)
            ->select(['id', 'name', 'password'])
            ->where('name', $this->getTitle(), '=')
            ->execute($this->conn);
        return $queryResult;
    }

    /** Check If User Exists With Name And Password */

    public function checkIfUserExistsWithNameAndPassword()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName(self::TABLE)
            ->select(['id', 'name', 'password'])
            ->where('name', $this->getTitle(), '=')
            ->where('password', $this->password, '=')
            ->execute($this->conn);
        return $queryResult;
    }
}