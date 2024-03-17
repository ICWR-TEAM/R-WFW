<?php

class Home extends Controller
{

    public function index()
    {

        $data['title'] = 'R-WFW (Rusher Web FrameWork)';
        $data['url'] = BASEURL . "/about";

        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer', $data);

    }

}
