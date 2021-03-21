<?php

namespace src\controllers;

abstract class CoreController
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}