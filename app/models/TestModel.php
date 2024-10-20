<?php

namespace App\Models;

use App\Core\Model;

class TestModel extends Model
{

    public function testFunc(): string
    {
        return 'Test Models';
    }

}