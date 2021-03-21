<?php

namespace src\controllers;

class LoginController extends CoreController
{
    public function postAction($request)
    {
        $password = isset($request['userPassword']) ? $request['userPassword'] : '';
        $this->model->setTitle($request['userName']);
        $this->model->setPassword($password);
        $existingUser = $this->model->checkIfUserExistsWithNameAndPassword();
        if (!$existingUser) {
            $_SESSION['loginErrorMessage'] = 'Incorrect login or password! Please, try again:';
            header("Location: /login");
        } else {
            session_start();
            $_SESSION['userId'] = $existingUser[0]['id'];
            $_SESSION['userName'] = $existingUser[0]['name'];
            unset($_SESSION['loginErrorMessage']);
            header("Location: /");
        }
    }
}