<?php

/* Connect to DB */

require_once 'vendor/autoload.php';

use src\config\Database;

$database = new Database();
$databaseConnection = $database->getConnection();