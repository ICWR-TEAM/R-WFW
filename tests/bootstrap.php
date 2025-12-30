<?php

// Bootstrap file for PHPUnit tests
require_once __DIR__ . '/../app/libraries/autoload.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/ErrorHandling.php';
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Authentication.php';
require_once __DIR__ . '/../app/core/Model.php';
require_once __DIR__ . '/../app/core/Library.php';
require_once __DIR__ . '/../app/core/Flasher.php';
require_once __DIR__ . '/../app/core/r_crud.php';
require_once __DIR__ . '/../app/core/Request.php';
require_once __DIR__ . '/../app/core/Response.php';
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Security.php';

require_once __DIR__ . '/../app/middleware/Auth.php';
require_once __DIR__ . '/../app/middleware/Header.php';

// Load controllers
require_once __DIR__ . '/../app/controllers/Home.php';
require_once __DIR__ . '/../app/controllers/About.php';

// Load models
require_once __DIR__ . '/../app/models/HomeModel.php';

// Define constants for testing
if (!defined('DEV_MODE')) define('DEV_MODE', true);
if (!defined('DEV_BASEURL')) define('DEV_BASEURL', 'http://localhost:8090');
if (!defined('BASEURL')) define('BASEURL', 'https://example.com');
if (!defined('DB_USE')) define('DB_USE', false);
if (!defined('ALLOW_ALL_CORS')) define('ALLOW_ALL_CORS', false);
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_USER')) define('DB_USER', 'test');
if (!defined('DB_PASS')) define('DB_PASS', 'test');
if (!defined('DB_NAME')) define('DB_NAME', 'test');
if (!defined('ALL_SECURITY_HEADERS')) define('ALL_SECURITY_HEADERS', false);
if (!defined('ANTI_XSS')) define('ANTI_XSS', false);
if (!defined('SECRET_KEY_JWT')) define('SECRET_KEY_JWT', 'test-secret');
if (!defined('SIGNATURE_PRIVATE_KEY')) define('SIGNATURE_PRIVATE_KEY', '../data/signature/private_key.pem');
if (!defined('SIGNATURE_PUBLIC_KEY')) define('SIGNATURE_PUBLIC_KEY', '../data/signature/public_key.pem');