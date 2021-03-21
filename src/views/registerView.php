<?php

namespace src\views;

class RegisterView extends CoreView
{
    public function output()
    {
        $pageTitle = "Registration Form";
        $currentView = 'src/views/templates/registerTemplate.php';
        $errorMessage =  $_SESSION['regErrorMessage'] ? $_SESSION['regErrorMessage'] : "";
        include('src/views/templates/templateView.php');
    }
}