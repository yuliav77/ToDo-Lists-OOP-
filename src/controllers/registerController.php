<?php

namespace src\controllers;

use src\views\RegisterView;

class RegisterController extends CoreController
{
    public function postAction($request)
    {
        $password = isset($request['userPassword']) ? $request['userPassword'] : '';
        $this->model->setTitle($request['userName']);
        $this->model->setPassword($password);
        $existingUserWithName = $this->model->checkIfUserExistsWithName();
        if (empty($existingUserWithName)) {
            if ($this->model->create()) {
                $_SESSION['userId'] = $this->model->getId();
                $_SESSION['userName'] = $this->model->getTitle();
                unset($_SESSION['regErrorMessage']);
                header("Location: /");
            }
        } else {
            $_SESSION['regErrorMessage'] = "You can not use this name, we have already had such user!";
            header("Location: /register");
        }
    }

    public function render()
    {
        $this->view = new RegisterView($this);
        echo $this->view->output();
    }
}