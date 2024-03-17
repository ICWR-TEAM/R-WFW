<?php

class TestParameterModel
{

    public function testFunc($parameters)
    {

        if (is_numeric($parameters[1]) && is_numeric($parameters[2])) {

            $plus = $parameters[1] + $parameters[2];

            $output = "Parameter 1 ( {$parameters[1]} ) + Parameter 2 ( {$parameters[2]} ) = {$plus}";

        } else {

            $output = 'Please use numeric parameters!';

        }

        return $output;
    }

}