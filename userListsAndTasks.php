<?php

session_start();

if (empty($_SESSION['userId'])) {
    header('Location: login.php');
}

$authorizedUserId = $_SESSION['userId'];
$authorizedUserName =  $_SESSION['userName'];

/* Connect to DB */

include_once "config/database.php";
include_once "models/user.php";
include_once "models/list.php";
include_once "models/task.php";

$database = new Database();
$databaseConnection = $database->getConnection();


/* Read all lists of authorized user */

$todoList = new ToDoList($databaseConnection);
$todoList->userId = $authorizedUserId;
$userLists = $todoList->readAllListsOfUser();
$lists = [];


/* Add tasks to user lists array */

foreach ($userLists as $list) {
    $toDoTask = new Task($databaseConnection);
    $toDoTask->listId = $list['id'];
    $tasks = $toDoTask->readAllTasksOfList();
    $list['tasks'] = $tasks;
    $lists[] = $list;
}