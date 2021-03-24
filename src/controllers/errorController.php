<?php

namespace src\controllers;

use src\views\Error404View;

class ErrorController extends CoreController
{
    public function render()
    {
        $this->view = new Error404View($this);
        echo $this->view->output();
    }
}
