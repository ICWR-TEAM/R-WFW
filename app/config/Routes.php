<?php

namespace App\Config\Routes;
require_once('../app/core/Router.php');
use App\Core\Router;

$route = new Router();

$route->RoutesName(name: 'test/get', context: ['route' => $route]);
$route->RoutesName(name: 'test/post', context: ['route' => $route]);
$route->RoutesName(name: 'test/options', context: ['route' => $route]);

// System

$route->Route(method: 'get', url: '/updater', handler: "Update::install");

$route->handleRoute();
