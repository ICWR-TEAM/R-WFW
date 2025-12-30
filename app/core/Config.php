<?php

namespace App\Core;

class Config
{

    private function allowAllCORS(): void
    {
        header(header: "Access-Control-Allow-Origin: *");
        header(header: "Access-Control-Allow-Methods: *");
        header(header: "Access-Control-Allow-Headers: *");
        header(header: "Access-Control-Allow-Credentials: true");
        header(header: "Server: Hiddened");
    }

    public function __construct()
    {
        (DEV_MODE) ? (error_reporting(error_level: E_ALL) && ini_set(option: "display_errors", value: 1)) : (error_reporting(error_level: 0) && ini_set(option: "display_errors", value: 0));
        (ALLOW_ALL_CORS) ? ($this->allowAllCORS()) : null;
    }
}
