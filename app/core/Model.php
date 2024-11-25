<?php

namespace App\Core;

use App\Core\Updater;
use App\Core\Database;
use App\Core\Response;
use App\Middleware\Auth;
use App\Middleware\Header;

class Model
{
    public $auth;
    public $db;
    public $response;
    public $header;

    public function __construct()
    {
        if (UPDATER) {
            $this->updater = new Updater();
        }

        if (DB_USE) {
            $this->db = new Database();
        }

        $this->auth = new Auth(secretKey: SECRET_KEY_JWT, privateKeyPath: SIGNATURE_PRIVATE_KEY, publicKeyPath: SIGNATURE_PUBLIC_KEY);
        $this->header = new Header();
    }
}
