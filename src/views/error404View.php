<?php

namespace src\views;

class Error404View extends CoreView
{
    public function output()
    {
        $pageTitle = "Error 404";
        $currentView = 'src/views/templates/ErrorTemplate.php';
        include('src/views/templates/templateView.php');
    }
}
