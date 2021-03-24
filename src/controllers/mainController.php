<?php

namespace src\controllers;

use src\models\ToDoList;
use src\models\Task;
use src\views\MainView;
use src\views\Error404View;

class MainController extends CoreController
{
    public function logout()
    {
        session_start();
        unset($_SESSION["userId"]);
        unset($_SESSION["userName"]);
        unset($_SESSION["listId"]);
        unset($_SESSION["regErrorMessage"]);
        unset($_SESSION["loginErrorMessage"]);
        header("Location: /login");
    }

    public function postAction($request, $databaseConnection)
    {
        if (isset($request['submitNewList'])) {

            /* Add a new todolist */

            $todoList = new ToDoList($databaseConnection);
            $todoList->setUserId($request['userId']);
            $todoList->setTitle($request['title']);
            if ($todoList->create()) {
                $listId = $todoList->getId();
            }

        } elseif (isset($request['submitNewTask'])) {

            /* Add a new task */

            $task = new Task($databaseConnection);
            $task->setListId($request['listId']);
            $task->setTitle($request['title']);
            $task->create();

        } elseif (isset($_POST['delete'])) {

            /* Delete a task */

            $taskToDelete = new Task($databaseConnection);
            $taskToDelete->setId($_POST['taskId']);
            $taskToDelete->delete();

        } elseif (isset($_POST['taskIdForCheck'])) {

            /* Modify "is_done" of a task */

            $isDone = isset($_POST['checkIsDone']) ? 1 : 0;
            $taskToModifyDone = new Task($databaseConnection);
            $taskToModifyDone->setId($_POST['taskIdForCheck']);
            $taskToModifyDone->setIsDone($isDone) ;
            $taskToModifyDone->mark();
        }

        if (isset($_POST['listId']) || $listId) {
            session_start();
            $_SESSION['listId'] = isset($_POST['listId']) ? $_POST['listId'] : $listId;
        }

        header("Location: /");
    }

    public function getId()
    {
        return $this->model->getId();
    }

    public function getTitle()
    {
        return $this->model->getTitle();
    }

    public function getLists()
    {
        return $this->model->getLists();
    }

    public function render()
    {
        $this->view = new MainView($this);
        echo $this->view->output();
    }
}