<?php

namespace App\Config\Routes;

require_once('../app/core/Router.php');
use App\Core\Router;

$route = new Router();
$baseDir = __DIR__ . '/../config/Routes/';

function loadRouteFiles($dir, $route): void {
    $files = glob(pattern: $dir . '*.php'); 

    foreach ($files as $file) {
        $routeName = str_replace(search: __DIR__ . '/../config/Routes/', replace: '', subject: $file);  
        $routeName = str_replace(search: '.php', replace: '', subject: $routeName);
        $route->RoutesName(name: $routeName, context: [
            'route' => $route
        ]);
    }
    
    $subDirs = glob(pattern: $dir . '*', flags: GLOB_ONLYDIR);

    foreach ($subDirs as $subDir) {
        loadRouteFiles(dir: $subDir . '/', route: $route); 
    }
}

loadRouteFiles(dir: $baseDir, route: $route);

$route->handleRoute();
