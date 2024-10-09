<?php

namespace App\Core;

class Config
{

    private function allowAllCORS()
    {

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Credentials: true");
        header("Server: Hiddened");

    }

    public function __construct()
    {

        (DEV_MODE) ? (error_reporting(E_ALL) && ini_set("display_errors", 1)) : (error_reporting(0) && ini_set("display_errors", 0));
        (ALLOW_ALL_CORS) ? ($this->allowAllCORS()) : null;


    }

}
