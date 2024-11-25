<?php

namespace App\Controllers;

use App\Core\Controller;

class Cors extends Controller
{

    public function test(): void
    {
        if ($data['response'] = $this->model(model: 'CorsModel')->Test()) {
            $this->view(view: 'api/index', data: $data);
        }
    }
}
