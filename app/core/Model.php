<?php

namespace App\Core;

use App\Core\Database;

class Model
{

    public function __construct()
    {

        if (DB_USE) {

            $this->db = new Database();
            
        }
        

    }

}
