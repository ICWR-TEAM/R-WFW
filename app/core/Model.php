<?php

namespace App\Core;

use App\Core\Database;

class Model
{

    public function __construct()
    {

        if (USE_DB) {

            $this->db = new Database();
            
        }
        

    }

}
