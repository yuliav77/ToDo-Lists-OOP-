<?php

/* Connect to DB */
require_once "config/database.php";
require_once "models/user.php";
require_once "models/todolist.php";
require_once "models/task.php";

use config\Database;

$database = new Database();
$databaseConnection = $database->getConnection();
