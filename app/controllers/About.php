<?php

class About extends Controller
{

    public function index()
    {

        $data['title'] = 'About Us - incrustwerush.org';

        $this->view('templates/header', $data);
        $this->view('home/about', $data);
        $this->view('templates/footer', $data);

    }

}