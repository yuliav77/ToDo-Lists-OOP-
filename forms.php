<?php

session_start();

/* Connect to DB */

require_once "connect.php";
use models\User;
use models\ToDoList;
use models\Task;


/* Form processing */

if(isset($_POST["submitNewList"])) {

    /* Add a new ToDoList */

    $todoList = new ToDoList($databaseConnection);
    $todoList->title = $_POST["listTitle"];
    $todoList->userId = $_POST["userId"];
    $todoList->create();
    $listId = $todoList->id;

} elseif(isset($_POST['taskIdForCheck'])) {

    /* Modify "is_done" of a task */

    $taskToModifyDone = new Task($databaseConnection);
    $taskToModifyDone->id = $_POST['taskIdForCheck'];
    $taskToModifyDone->isDone = isset($_POST['checkIsDone']) ? 1 : 0;
    $taskToModifyDone->mark();

} elseif(isset($_POST['submitNewTask'])) {

    /* Add a new task */

    $taskToAdd = new Task($databaseConnection);
    $taskToAdd->title = $_POST['taskTitle'];
    $taskToAdd->listId = $_POST['listId'];
    $taskToAdd->create();

} elseif(isset($_POST['delete'])) {

    /* Delete a task */

    $taskToDelete =  new Task($databaseConnection);
    $taskToDelete->id = $_POST['taskId'];
    $taskToDelete->delete();

} elseif(isset($_POST['submitUser'])) {

    /* Login user */

    $userToLogin = new User($databaseConnection);
    $userToLogin->name = $_POST['userName'];
    $userToLogin->password = isset($_POST['userPassword']) ? $_POST['userPassword'] : '';
    $existingUser = $userToLogin->checkIfUserExistsWithNameAndPassword();
    if(!$existingUser) {
        $_SESSION['loginErrorMessage'] = 'Incorrect login or password! Please, try again:';
    } else {
        session_start();
        $_SESSION['userId'] = $existingUser;
        $_SESSION['userName'] = $userToLogin->name;
        unset($_SESSION['loginErrorMessage']);
    }

} elseif(isset($_POST['submitNewUser'])) {

    /* Create new user */

    $userToRegister = new User($databaseConnection);
    $userToRegister->name = $_POST['userName'];
    $userToRegister->password = isset($_POST['userPassword']) ? $_POST['userPassword'] : '';
    $existingUserWithName = $userToRegister->checkIfUserExistsWithName();

    if (empty($existingUserWithName)) {
        if ($userToRegister->create()) {
            $_SESSION['userId'] = $userToRegister->id;
            $_SESSION['userName'] = $userToRegister->name;
            unset($_SESSION['regErrorMessage']);
        }
    } else {
        $_SESSION['regErrorMessage'] = "You can not use this name, we have already had such user!";

    }
}


/* Remember in $_SESSION the id of TODOlist which was modified or created */

if (isset($_POST['listId']) || $listId) {
    $_SESSION['listId'] = isset($_POST['listId']) ? $_POST['listId'] : $listId;
}


if (isset( $_SESSION['regErrorMessage'])) {

    /* Return to register.php page */

    header('Location:register.php');

} else {

    /* Return to index.php page */

    header('Location: /');
}
