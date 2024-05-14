<?php

namespace App\Models;

use App\Core\Model;

class TestDBModel extends Model
{

    public function testFunc()
    {

        $output = $this->db->query("SELECT * FROM test");

        return $output;
    }

}
