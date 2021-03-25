<?php

namespace src\config;

class Database
{
    private $conn;
    private static $instance = null;
    private $host = "localhost";
    private $dbName = "project";
    private $userName = "root";
    private $password = "";

    private function __construct()
    {
        try {
            $this->conn = new \PDO(
                sprintf('mysql:host=%s;dbname=%s', $this->host, $this->dbName),
                $this->userName,
                $this->password,
            );
        } catch (PDOException $exception) {
            echo "Connection Error: " . $exception->getMessage();
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

}
