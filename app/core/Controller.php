<?php

namespace App\Core;

use App\Core\Config;
use App\Core\Security;

class Controller
{

    public function __construct()
    {
        new Config();
        new Security();
    }

    public function view(string $view, array $data = []): void
    {
        require_once('../app/views/' . $view . '.php');
    }

    public function model(string $model): object
    {
        require_once('../app/models/' . $model . '.php');

        $parts = explode(separator: "/", string: $model);
        $modelName = 'App\\Models\\' . end(array: $parts);

        return new $modelName;
    }
}
