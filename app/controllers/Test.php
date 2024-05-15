<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Flasher;

class Test extends Controller
{

    public function index()
    {

        $data['title'] = 'Test';

        $this->view('templates/header', $data);

        if ($msg = $this->model('TestModel')->testFunc()) {

            Flasher::setFlash($msg, 'print', 'success');
            Flasher::flash();

        }

        $this->view('templates/footer', $data);

    }

    public function post()
    {

        echo 'Test Post';

    }

}