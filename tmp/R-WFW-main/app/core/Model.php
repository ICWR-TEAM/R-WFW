<?php

namespace App\Core;

use App\Core\Config;
use App\Core\Security;
use App\Core\Updater;
use App\Core\Database;

class Model
{

    public function __construct()
    {

        new Config();
        new Security();

        if (UPDATER) {

            $this->updater = new Updater();
            
        }

        if (DB_USE) {

            $this->db = new Database();
            
        }

    }

}
