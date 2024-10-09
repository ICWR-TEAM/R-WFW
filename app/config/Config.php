<?php

namespace App\Config\Config;

define(constant_name: 'BASEURL', value: 'http://localhost:8080');

// Database

define(constant_name: 'DB_HOST', value: 'incrustwerush.org');
define(constant_name: 'DB_USER', value: 'incrustwerush.org');
define(constant_name: 'DB_PASS', value: 'incrustwerush.org');
define(constant_name: 'DB_NAME', value: 'incrustwerush.org');

// Configuration

define(constant_name: 'UPDATER', value: false); // true or false
define(constant_name: 'UPDATER_PASSWD', value: 'incrustwerush.org'); // Change Password for Update
define(constant_name: 'DEV_MODE', value: true); // true or false
define(constant_name: 'DB_USE', value: false); // true or false
define(constant_name: 'ALLOW_ALL_CORS', value: false); // true or false

// Security

define(constant_name: 'ALL_SECURITY_HEADERS', value: false); // true or false
define(constant_name: 'ANTI_XSS', value: false); // true or false

// Secret Key JWT

define(constant_name: 'SECRET_KEY_JWT', value: 'secret_key_jwt');
