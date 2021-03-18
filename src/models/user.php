<?php

namespace src\models;

class User extends Element
{
    private $password;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->tableName = "users";
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function create()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName($this->tableName)
            ->insert(["name", "password"], [$this->getTitle(), $this->password])
            ->execute($this->conn);
        $this->setId($queryResult);

        return $queryResult;
    }

    public function checkIfUserExistsWithName()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName($this->tableName)
            ->select(["id", "name", "password"])
            ->where("name", $this->getTitle(), "=")
            ->execute($this->conn);

        return $queryResult;
    }

    public function checkIfUserExistsWithNameAndPassword ()
    {
        $sqlString = new SQLbuilder();
        $queryResult = $sqlString
            ->setTableName($this->tableName)
            ->select(["id", "name", "password"])
            ->where("name", $this->getTitle(), "=")
            ->where("password", $this->password, "=")
            ->execute($this->conn);

        return $queryResult;
    }

}