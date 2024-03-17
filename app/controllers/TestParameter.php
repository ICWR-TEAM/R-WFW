<?php

class TestParameter extends Controller
{

    public function index($parameters)
    {

        $data['title'] = 'Test';

        $this->view('templates/header', $data);

        if ($data['result'] = $this->model('TestParameterModel')->testFunc($parameters)) {

            $this->view('home/parameter', $data);

        }

        $this->view('templates/footer', $data);

    }

}