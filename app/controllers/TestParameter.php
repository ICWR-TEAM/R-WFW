<?php

namespace App\Controllers;

use App\Core\Controller;

class TestParameter extends Controller
{

    public function index($parameters): void
    {
        $data['title'] = 'Test';

        $this->view(view: 'templates/header', data: $data);

        if ($data['result'] = $this->model(model: 'TestParameterModel')->testFunc($parameters)) {
            $this->view(view: 'home/parameter', data: $data);
        }

        $this->view(view: 'templates/footer', data: $data);
    }

}