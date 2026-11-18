<?php

class Controller
{
    protected $views;
    protected $model;

    public function __construct()
    {
        $this->views = new Views();
        $this->loadModel();
    }

    public function loadModel()
    {
        $modelName = str_replace('Controller', 'Model', get_class($this));
        $modelPath = ROOT_PATH . '/Models/' . $modelName . '.php';

        if (is_file($modelPath)) {
            require_once $modelPath;
            $this->model = new $modelName();
        }
    }
}
