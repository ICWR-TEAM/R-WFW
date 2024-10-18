<?php

namespace App\Controllers;

use App\Core\Controller;

class AuthTest extends Controller
{

    public function login(): void
    {

        if ($data['response'] = $this->model(model: 'AuthTestModel')->Auth()) {

            $this->view(view: 'api/index', data: $data);

        }

    }

    public function check(): void
    {

        if ($data['response'] = $this->model(model: 'AuthTestModel')->Check()) {

            $this->view(view: 'api/index', data: $data);

        }

    }

}
