<?php

namespace App\Models;

use App\Core\Model;

class TestDBModel extends Model
{
    public $db;

    public function testFunc(): mixed
    {

        $output = $this->db->query_fetch_array("SELECT * FROM test");

        return $output;
    }

}
