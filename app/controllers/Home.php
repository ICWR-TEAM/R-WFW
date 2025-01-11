<?php

namespace App\Controllers;

use App\Core\Controller;

class Home extends Controller
{

    public function index(): void
    {
        $data['title'] = 'R-WFW (Rusher Web FrameWork)';
        $data['url'] = BASEURL . "/test/about";
        $data['description'] = $this->model(model: 'HomeModel')->description();

        $this->view(view: 'templates/header', data: $data);
        $this->view(view: 'home/index', data: $data);
        $this->view(view: 'templates/footer', data: $data);
    }
}
