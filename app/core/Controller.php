<?php

namespace App\Core;

class Controller
{

    public function view(string $view, array $data = []): void
    {

        require_once('../app/views/' . $view . '.php');

    }

    public function model(string $model): object
    {

        require_once('../app/models/' . $model . '.php');
        $modelName = 'App\\Models\\' . $model;

        return new $modelName;

    }

}
