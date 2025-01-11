<?php

namespace App\Config\Config;

define(constant_name: 'BASEURL', value: 'http://localhost:8090');

// Database

define(constant_name: 'DB_HOST', value: 'incrustwerush.org');
define(constant_name: 'DB_USER', value: 'incrustwerush.org');
define(constant_name: 'DB_PASS', value: 'incrustwerush.org');
define(constant_name: 'DB_NAME', value: 'incrustwerush.org');

// Configuration

define(constant_name: 'DEV_MODE', value: true); // true or false
define(constant_name: 'DB_USE', value: false); // true or false
define(constant_name: 'ALLOW_ALL_CORS', value: false); // true or false

// Security

define(constant_name: 'ALL_SECURITY_HEADERS', value: false); // true or false
define(constant_name: 'ANTI_XSS', value: false); // true or false

// JWT Secret Key

define(constant_name: 'SECRET_KEY_JWT', value: 'incrustwerush.org'); // Change JWT Secret Key

// Signature Public and Private Key

define(constant_name: 'SIGNATURE_PRIVATE_KEY', value: '../data/signature/private_key.pem'); // Change Path Key
define(constant_name: 'SIGNATURE_PUBLIC_KEY', value: '../data/signature/public_key.pem'); // Change Path Key
