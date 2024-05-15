<?php

namespace App\Core;

use App\Controllers;

class Router
{

    private $routes = [];

    private function Controller($handler, $parameter = [])
    {

        $split_handler = explode("::", $handler);

        $controller_file = '../app/controllers/' . $split_handler[0] . '.php';

        require_once($controller_file);

        $className = 'App\\Controllers\\' . $split_handler[0];
        $class = new $className();

        $functionName = $split_handler[1];

        if (!empty($parameter)) {

            $class->$functionName($parameter);

        } else {

            $class->$functionName();

        }

    }

    public function Route($method, $url, $handler)
    {

        $this->routes[] = [

            'method' => $method,
            'url' => $url,
            'handler' => $handler

        ];

    }

    public function handleRoute()
    {

        $parts = explode('/', BASEURL);

        if ($specificPart = implode('/', array_slice($parts, 3))) {

            $url = '/' . ltrim($_SERVER['REQUEST_URI'], $specificPart . '/');
            $url = rtrim($url, '/');

        } else {

            $url = rtrim($_SERVER['REQUEST_URI'], '/');

        }

        $url = explode('?', $url)[0];
        $url_parts = explode('/', $url);
        $method_not_allowed = false;

        foreach ($this->routes as $route)
        {

            $route_parts = $this->parseURLFromRoute($route['url']);

            if (count($url_parts) === count($route_parts)) {

                $parameters = [];
                $match = true;

                for ($i = 0; $i < count($url_parts); $i++)
                {

                    if (!empty($route_parts[$i]) && $route_parts[$i][0] === '{' && $route_parts[$i][strlen($route_parts[$i]) - 1] === '}') {
                        
                        $parameter_name = substr($route_parts[$i], 1, -1);
                        $parameters[$parameter_name] = $url_parts[$i];

                    } elseif ($url_parts[$i] !== $route_parts[$i]) {

                        $match = false;
                        break;

                    }

                }

                if ($match) {

                    if ($_SERVER['REQUEST_METHOD'] === strtoupper($route['method'])) {
                        
                        $this->Controller($route['handler'], $parameters);
                        return;

                    } else {

                        $method_not_allowed = true;

                    }

                }

            }

        }

        if ($method_not_allowed) {

            header("HTTP/1.0 405 Method Not Allowed");
            echo 'Method Not Allowed!';

        } else {

            header("HTTP/1.0 404 Not Found");
            echo 'Not Found!';
            
        }

    }

    private function parseURLFromRoute($routeUrl)
    {

        $url = rtrim($routeUrl, '/');
        $url_parts = explode('/', $url);

        return $url_parts;
        
    }

}
