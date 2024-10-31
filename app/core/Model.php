<?php

namespace App\Core;

use App\Core\Updater;
use App\Core\Database;
use App\Core\Response;
use App\Middleware\Auth;

class Model
{
    public $auth;
    public $db;
    public $response;

    public function __construct()
    {
        if (UPDATER) {
            $this->updater = new Updater();
        }

        if (DB_USE) {
            $this->db = new Database();
        }

        $this->response = new Response();
        $this->auth = new Auth(secretKey: SECRET_KEY_JWT, privateKeyPath: SIGNATURE_PRIVATE_KEY, publicKeyPath: SIGNATURE_PUBLIC_KEY);
    }
}
