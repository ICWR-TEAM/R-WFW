<?php

namespace App\Config\Config;

define('BASEURL', 'http://localhost:8080');

// Database

define('DB_HOST', 'incrustwerush.org');
define('DB_USER', 'incrustwerush.org');
define('DB_PASS', 'incrustwerush.org');
define('DB_NAME', 'incrustwerush.org');

// Configuration

define('UPDATER', false); // true or false
define('UPDATER_PASSWD', 'incrustwerush.org'); // Change Password for Update
define('DEV_MODE', true); // true or false
define('DB_USE', false); // true or false
define('ALLOW_ALL_CORS', false); // true or false

// Security

define('ALL_SECURITY_HEADERS', false); // true or false
define('ANTI_XSS', false); // true or false

// Secret Key JWT

define('SECRET_KEY_JWT', 'secret_key_jwt');
