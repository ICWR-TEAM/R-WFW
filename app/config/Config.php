<?php

namespace App\Config\Config;

define('BASEURL', 'http://localhost:8080');

// Database

define('DB_HOST', 'incrustwerush.org');
define('DB_USER', 'incrustwerush.org');
define('DB_PASS', 'incrustwerush.org');
define('DB_NAME', 'incrustwerush.org');

// Configuration

define('DEV_MODE', true); // true or false
define('DB_USE', false); // true or false

// ---

(DEV_MODE) ? (error_reporting(E_ALL) && ini_set("display_errors", 1)) : (error_reporting(0) && ini_set("display_errors", 0));