<?php

define('BASEURL', 'http://localhost:8080');

// Database

define('DB_HOST', 'localhost');
define('DB_USER', 'incrustwerush.org');
define('DB_PASS', 'incrustwerush.org');
define('DB_NAME', 'incrustwerush.org');

// Configuration

$developmentMode = true; // true or false

// ---

if ($developmentMode === false) error_reporting(0);