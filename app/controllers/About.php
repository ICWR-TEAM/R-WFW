<?php

namespace App\Controllers;

use App\Core\Controller;

class About extends Controller
{

    public function index(): void
    {
        $data['title'] = 'About Us - incrustwerush.org';

        $this->view(view: 'templates/header', data: $data);
        $this->view(view: 'home/about', data: $data);
        $this->view(view: 'templates/footer', data: $data);
    }
}
