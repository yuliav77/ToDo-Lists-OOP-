<?php

session_start();

if (empty($_SESSION['userId'])) {
    header('Location: login.php');
}

$authorizedUserId = $_SESSION['userId'];
$authorizedUserName =  $_SESSION['userName'];

/* Connect to DB */

require_once "connect.php";
use src\models\ToDoList;
use src\models\Task;

/* Read all lists of authorized user */

$todoList = new ToDoList($databaseConnection);
$todoList->setUserId($authorizedUserId);
$userLists = $todoList->readAllListsOfUser();
$lists = [];


/* Add tasks to user lists array */

foreach ($userLists as $list) {
    $toDoTask = new Task($databaseConnection);
    $toDoTask->setListId($list['id']);
    $tasks = $toDoTask->readAllTasksOfList();
    $list['tasks'] = $tasks;
    $lists[] = $list;
}