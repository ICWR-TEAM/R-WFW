<?php

namespace App\Controllers;

use App\Core\Controller;

class TestDB extends Controller
{

    public function index(): void
    {
        $data['title'] = 'Test';

        $this->view(view: 'templates/header', data: $data);

        if ($data['result'] = $this->model(model: 'TestDBModel')->testFunc()) {
            $this->view(view: 'home/db', data: $data);
        }

        $this->view(view: 'templates/footer', data: $data);

    }
}
