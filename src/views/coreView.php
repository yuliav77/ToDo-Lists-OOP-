<?php

namespace src\views;

class CoreView
{
    /* protected $model;*/
    protected $controller;

    public function __construct($controller) {
        $this->controller = $controller;
        /*$this->model = $model;*/
    }

}