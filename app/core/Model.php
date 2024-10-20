<?php

namespace App\Core;

use App\Core\Updater;
use App\Core\Database;
use App\Middleware\Auth;

class Model
{
    public $auth;
    public $db;

    public function __construct()
    {
        if (UPDATER) {
            $this->updater = new Updater();
        }

        if (DB_USE) {
            $this->db = new Database();
        }

        $this->auth = new Auth(secretKey: SECRET_KEY_JWT);
    }
}
