<?php

namespace src\views;

class MainView extends CoreView
{
    public function output()
    {
        $pageTitle = "ToDo Lists";
        $currentView = 'src/views/templates/mainTemplate.php';
        $authorizedUserId = $this->controller->getId();
        $authorizedUserName = $this->controller->getTitle();
        $lists = $this->controller->getLists();
        include('src/views/templates/templateView.php');
    }
}