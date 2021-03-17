<?php

session_start();

/* Connect to DB */

require_once "connect.php";
use src\models\User;
use src\models\ToDoList;
use src\models\Task;


/* Form processing */

if(isset($_POST["submitNewList"])) {

    /* Add a new ToDoList */

    $todoList = new ToDoList($databaseConnection);
    $todoList->setTitle($_POST["listTitle"]);
    $todoList->setUserId($_POST["userId"]);
    $todoList->create();
    $listId = $todoList->getId();

} elseif(isset($_POST['taskIdForCheck'])) {

    /* Modify "is_done" of a task */

    $isDone = isset($_POST['checkIsDone']) ? 1 : 0;
    $taskToModifyDone = new Task($databaseConnection);
    $taskToModifyDone->setId($_POST['taskIdForCheck']);
    $taskToModifyDone->setIsDone($isDone) ;
    $taskToModifyDone->mark();

} elseif(isset($_POST['submitNewTask'])) {

    /* Add a new task */

    $taskToAdd = new Task($databaseConnection);
    $taskToAdd->setTitle($_POST['taskTitle']);
    $taskToAdd->setListId($_POST['listId']);
    $taskToAdd->create();

} elseif(isset($_POST['delete'])) {

    /* Delete a task */

    $taskToDelete = new Task($databaseConnection);
    $taskToDelete->setId($_POST['taskId']);
    $taskToDelete->delete();

} elseif(isset($_POST['submitUser'])) {

    /* Login user */

    $password = isset($_POST['userPassword']) ? $_POST['userPassword'] : '';
    $userToLogin = new User($databaseConnection);
    $userToLogin->setTitle($_POST['userName']);
    $userToLogin->setPassword($password);
    $existingUser = $userToLogin->checkIfUserExistsWithNameAndPassword();
    if(!$existingUser) {
        $_SESSION['loginErrorMessage'] = 'Incorrect login or password! Please, try again:';
    } else {
        session_start();
        $_SESSION['userId'] = $existingUser[0]['id'];
        $_SESSION['userName'] = $userToLogin->getTitle();
        unset($_SESSION['loginErrorMessage']);
    }

} elseif(isset($_POST['submitNewUser'])) {

    /* Create new user */

    $password = isset($_POST['userPassword']) ? $_POST['userPassword'] : '';
    $userToRegister = new User($databaseConnection);
    $userToRegister->setTitle($_POST['userName']);
    $userToRegister->setPassword($password);
    $existingUserWithName = $userToRegister->checkIfUserExistsWithName();

    if (empty($existingUserWithName)) {
        if ($userToRegister->create()) {
            $_SESSION['userId'] = $userToRegister->getId();
            $_SESSION['userName'] = $userToRegister->getTitle();
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
