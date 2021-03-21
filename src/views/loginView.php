<?php

namespace src\views;

class LoginView extends CoreView
{
    public function output()
    {
        $pageTitle = "Login";
        $currentView = 'src/views/templates/loginTemplate.php';
        $errorMessage =  $_SESSION['loginErrorMessage'] ? $_SESSION['loginErrorMessage'] : "";
        include('src/views/templates/templateView.php');
    }
}