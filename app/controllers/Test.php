<?php

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

}