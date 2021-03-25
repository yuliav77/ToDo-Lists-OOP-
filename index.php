<?php

session_start();

require_once 'vendor/autoload.php';

use src\config\App;

$app = new App();
$app->init();
$app->run();