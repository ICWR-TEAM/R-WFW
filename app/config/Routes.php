<?php

namespace App\Config\Routes;

require_once('../app/core/Router.php');

use App\Core\Router;

$route = new Router();

$route->Route(method: 'get', url: '/', handler: "Home::index");
$route->Route(method: 'get', url: '/about', handler: "About::index");
$route->Route(method: 'get', url: '/error', handler: "Error::index");
$route->Route(method: 'get', url: '/test', handler: "Test::index");
$route->Route(method: 'get', url: '/testparameter/{1}/testagain/{2}/', handler: "TestParameter::index");
$route->Route(method: 'get', url: '/testdb', handler: "TestDB::index");
$route->Route(method: 'post', url: '/test', handler: "Test::post");
$route->Route(method: 'post', url: '/test/post', handler: "Test::post");
$route->Route(method: 'post', url: '/test/auth/login', handler: "AuthTest::login");
$route->Route(method: 'post', url: '/test/auth/check', handler: "AuthTest::check");
$route->Route(method: 'post', url: '/test/auth/check_header', handler: "AuthTest::checkHeader");
$route->Route(method: 'post', url: '/test/sign/create', handler: "Signature::create");
$route->Route(method: 'post', url: '/test/sign/check', handler: "Signature::check");
$route->Route(method: 'post', url: '/test/sign/specific/create', handler: "Signature::signSpecific");
$route->Route(method: 'post', url: '/test/sign/specific/check', handler: "Signature::signSpecificCheck");

// System

$route->Route(method: 'get', url: '/updater', handler: "Update::install");

$route->handleRoute();
