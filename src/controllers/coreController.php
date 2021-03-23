<?php

namespace src\controllers;

abstract class CoreController
{
    protected $model;
    protected $view;

    public function __construct($model)
    {
        $this->model = $model;
    }

    abstract public function render();

}