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
            if (DEV_MODE) {
                $this->db = new Database(db_host: DEV_DB_HOST, db_user: DEV_DB_USER, db_pass: DEV_DB_PASS, db_name: DEV_DB_NAME);
            } else {
                $this->db = new Database(db_host: DB_HOST, db_user: DB_USER, db_pass: DB_PASS, db_name: DB_NAME);
            }
        }

        $this->authentication = new Authentication();
    }
}
