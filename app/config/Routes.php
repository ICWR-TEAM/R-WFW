<?php

require_once('../app/core/Router.php');

$route = new Routing();

$route->Route('get', '/', "Home::index");
$route->Route('get', '/about', "About::index");
$route->Route('get', '/test', "Test::index");
$route->Route('get', '/testparameter/{1}/testagain/{2}/', "TestParameter::index");
$route->Route('get', '/testdb', "TestDB::index");

$route->handleRoute();
