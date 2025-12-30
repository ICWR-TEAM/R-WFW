<?php

namespace App\Core;

class Library
{
    public function load(string $class, array $constructParams = []): object
    {
        if (file_exists(filename: '../app/libraries/autoload.php')) {
            require_once('../app/libraries/autoload.php');
            
            if (!empty($constructParams)) {
                return new $class(...$constructParams);
            } else {
                return new $class();
            }
        } else {
            echo "Library not found!";
            exit();
        }
    }
}
