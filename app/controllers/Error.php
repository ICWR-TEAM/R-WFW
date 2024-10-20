<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\ErrorHandling;
use App\Core\Response;

new ErrorHandling();

class Error extends Controller
{

    public function index(): void
    {
        Response::setStatusCode(500);
        echo $data['title'];
    }
}
