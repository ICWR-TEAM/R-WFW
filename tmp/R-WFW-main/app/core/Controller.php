<?php

namespace App\Core;

class Controller
{

    public function view($view, $data = [])
    {

        require_once('../app/views/' . $view . '.php');

    }

    public function model($model)
    {

        require_once('../app/models/' . $model . '.php');
        $modelName = 'App\\Models\\' . $model;

        return new $modelName;

    }

}
