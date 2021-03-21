<?php

namespace src\views;

class MainView extends CoreView
{
    public function output()
    {
        $pageTitle = "ToDo Lists";
        $currentView = 'src/views/templates/mainTemplate.php';
        $authorizedUserId = $this->model->getId();
        $authorizedUserName = $this->model->getTitle();
        $lists = $this->model->getLists();
        include('src/views/templates/templateView.php');
    }
}