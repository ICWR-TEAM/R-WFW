<?php

// echo getcwd();

require_once('../app/core/Router.php');

$route = New Routing();

$route->Route('get', '/', "Home::index");
$route->Route('get', '/about', "About::index");
$route->Route('get', '/test', "Test::index");

$route->handleRoute();