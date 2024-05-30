<?php

namespace App\Config\Routes;

require_once('../app/core/Router.php');

use App\Core\Router;

$route = new Router();

$route->Route('get', '/', "Home::index");
$route->Route('get', '/about', "About::index");
$route->Route('get', '/test', "Test::index");
$route->Route('get', '/testparameter/{1}/testagain/{2}/', "TestParameter::index");
$route->Route('get', '/testdb', "TestDB::index");
$route->Route('post', '/test', "Test::post");
$route->Route('post', '/test/post', "Test::post");

// System

$route->Route('get', '/updater', "Update::install");

$route->handleRoute();
