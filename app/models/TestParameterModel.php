<?php

namespace App\Models;

use App\Core\Model;

class TestParameterModel extends Model
{

    public function testFunc(array $parameters): string
    {
        if (is_numeric(value: $parameters[1]) && is_numeric(value: $parameters[2])) {
            $plus = $parameters[1] + $parameters[2];
            $output = "Parameter 1 ( {$parameters[1]} ) + Parameter 2 ( {$parameters[2]} ) = {$plus}";
        } else {
            $output = 'Please use numeric parameters!';
        }

        return $output;
    }
}