<?php

namespace App\Controllers;

use App\Core\Controller;

class Signature extends Controller
{

    public function create(): void
    {
        if ($data['response'] = $this->model(model: 'SignatureModel')->Create()) {
            $this->view(view: 'api/index', data: $data);
        }
    }

    public function check(): void
    {
        if ($data['response'] = $this->model(model: 'SignatureModel')->Check()) {
            $this->view(view: 'api/index', data: $data);
        }
    }

    public function signSpecific(): void
    {
        if ($data['response'] = $this->model(model: 'SignatureModel')->SignSpecific()) {
            $this->view(view: 'api/index', data: $data);
        }
    }

    public function signSpecificCheck(): void
    {
        if ($data['response'] = $this->model(model: 'SignatureModel')->SignSPecificCheck()) {
            $this->view(view: 'api/index', data: $data);
        }
    }
}
