<?php

namespace src\config;

class Database
{
    private $host = "localhost";
    private $dbName = "project";
    private $userName = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new \PDO(
                sprintf('mysql:host=%s;dbname=%s', $this->host, $this->dbName),
                $this->userName,
                $this->password,
            );
        } catch(PDOException $exception) {
            echo "Connection Error: " . $exception->getMessage();
        }

        return $this->conn;
    }

}
