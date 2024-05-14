<?php

namespace App\Core;

use App\Core\Database;

class Model
{

    public function __construct()
    {

        $this->db = new Database();

    }

}