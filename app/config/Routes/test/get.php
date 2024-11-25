<?php

// GET

$route->Route(method: 'get', url: '/', handler: "Home::index");
$route->Route(method: 'get', url: '/about', handler: "About::index");
$route->Route(method: 'get', url: '/error', handler: "Error::index");
$route->Route(method: 'get', url: '/test', handler: "Test::index");
$route->Route(method: 'get', url: '/test/parameter/{1}/parameter/{2}/', handler: "TestParameter::index");
$route->Route(method: 'get', url: '/test/db', handler: "TestDB::index");
$route->Route(method: 'get', url: '/test/cors', handler: "Cors::test");

