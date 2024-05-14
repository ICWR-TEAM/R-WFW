<?php

namespace App\Controllers;

use App\Core\Controller;

class TestDB extends Controller
{

    public function index()
    {

        $data['title'] = 'Test';

        $this->view('templates/header', $data);

        if ($data['result'] = $this->model('TestDBModel')->testFunc()) {

            $this->view('home/db', $data);

        }

        $this->view('templates/footer', $data);

    }

}