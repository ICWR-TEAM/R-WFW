<?php

namespace App\Controllers;

use App\Core\Controller;

class TestPDF extends Controller
{

    public function index(): void
    {
        $this->model(model: 'TestPDFModel')->print("<h1>Hello World!</h1>This is my first test");
    }

    public function dompdf(): void
    {
        $this->model(model: 'TestPDFModel')->printDomPDF("<h1>Hello World!</h1>This is my first test");
    }
}
