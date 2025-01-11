<?php

// GET

$route->Route(method: 'get', url: '/', handler: "Home::index");
$route->Route(method: 'get', url: '/test/about', handler: "About::index");
