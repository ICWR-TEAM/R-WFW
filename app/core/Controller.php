<?php

namespace App\Core;

use App\Core\Config;
use App\Core\Security;
use App\Core\Request;
use App\Core\Response;

class Controller
{
    public $request;
    public $response;

    public function __construct()
    {
        new Config();
        new Security();

        $this->request = new Request();
        $this->response = new Response();
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
