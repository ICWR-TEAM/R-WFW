<?php

class Home extends Controller
{

    public function index()
    {

        $data['title'] = 'ICWR Framework';
        $data['url'] = BASEURL . "/about";

        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer', $data);

    }

}