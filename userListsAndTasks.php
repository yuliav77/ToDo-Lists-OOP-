<?php

session_start();

if (empty($_SESSION['userId'])) {
    header('Location: login.php');
}

$authorizedUserId = $_SESSION['userId'];
$authorizedUserName =  $_SESSION['userName'];

/* Connect to DB */

require_once "connect.php";
use src\models\User;


/* Read all lists of authorized user */

$user = new User($databaseConnection);
$user->setId($authorizedUserId);
$user->setLists();
$lists = $user->getLists();