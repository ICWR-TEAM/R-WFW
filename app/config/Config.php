<?php

namespace App\Config\Config;

use Dotenv\Dotenv;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Database DEV
define(constant_name: 'DEV_BASEURL', value: $_ENV['DEV_BASEURL'] ?? 'http://localhost:8090');
define(constant_name: 'DEV_DB_HOST', value: $_ENV['DEV_DB_HOST'] ?? 'db');
define(constant_name: 'DEV_DB_USER', value: $_ENV['DEV_DB_USER'] ?? 'root');
define(constant_name: 'DEV_DB_PASS', value: $_ENV['DEV_DB_PASS'] ?? 'root');
define(constant_name: 'DEV_DB_NAME', value: $_ENV['DEV_DB_NAME'] ?? 'test');

// Database
define(constant_name: 'BASEURL', value: $_ENV['BASEURL'] ?? 'http://localhost:8090');
define(constant_name: 'DB_HOST', value: $_ENV['DB_HOST'] ?? 'incrustwerush.org');
define(constant_name: 'DB_USER', value: $_ENV['DB_USER'] ?? 'incrustwerush.org');
define(constant_name: 'DB_PASS', value: $_ENV['DB_PASS'] ?? 'incrustwerush.org');
define(constant_name: 'DB_NAME', value: $_ENV['DB_NAME'] ?? 'incrustwerush.org');

// Configuration
define(constant_name: 'DEV_MODE', value: filter_var($_ENV['DEV_MODE'] ?? 'true', FILTER_VALIDATE_BOOLEAN));
define(constant_name: 'DB_USE', value: filter_var($_ENV['DB_USE'] ?? 'false', FILTER_VALIDATE_BOOLEAN));
define(constant_name: 'ALLOW_ALL_CORS', value: filter_var($_ENV['ALLOW_ALL_CORS'] ?? 'false', FILTER_VALIDATE_BOOLEAN));

// Security
define(constant_name: 'ALL_SECURITY_HEADERS', value: filter_var($_ENV['ALL_SECURITY_HEADERS'] ?? 'false', FILTER_VALIDATE_BOOLEAN));
define(constant_name: 'ANTI_XSS', value: filter_var($_ENV['ANTI_XSS'] ?? 'false', FILTER_VALIDATE_BOOLEAN));

// JWT Secret Key
define(constant_name: 'SECRET_KEY_JWT', value: $_ENV['SECRET_KEY_JWT'] ?? 'incrustwerush.org');

// Signature Public and Private Key
define(constant_name: 'SIGNATURE_PRIVATE_KEY', value: $_ENV['SIGNATURE_PRIVATE_KEY'] ?? '../data/signature/private_key.pem');
define(constant_name: 'SIGNATURE_PUBLIC_KEY', value: $_ENV['SIGNATURE_PUBLIC_KEY'] ?? '../data/signature/public_key.pem');
