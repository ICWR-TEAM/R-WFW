<?php

namespace App\Core;

use App\Core\Database;
use App\Core\Authentication;

class Model
{
    public $db;
    public $authentication;

    public function __construct()
    {
        if (DB_USE) {
            $this->db = new Database();
        }

        $this->authentication = new Authentication();
    }
}
