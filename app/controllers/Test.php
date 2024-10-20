<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Flasher;

class Test extends Controller
{

    public function index(): void
    {
        $data['title'] = 'Test';

        $this->view(view: 'templates/header', data: $data);

        if ($msg = $this->model(model: 'TestModel')->testFunc()) {
            Flasher::setFlash(msg: $msg, act: 'print', type: 'success');
            Flasher::flash();
        }

        $this->view(view: 'templates/footer', data: $data);
    }

    public function post(): void
    {
        echo 'Test Post';
    }
}
