<?php

namespace App\Controllers;

use App\Core\Controller;

class AuthTest extends Controller
{

    public function login()
    {

        if ($data['response'] = $this->model('AuthTestModel')->Auth()) {

            $this->view('api/index', $data);

        }

    }

}
