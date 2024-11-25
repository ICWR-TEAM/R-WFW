<?php

namespace App\Core;

use App\Controllers;

class Router
{

    private $routes = [];

    private function Controller(string $handler, array $parameter = []): void
    {
        $split_handler = explode(separator: "::", string: $handler);
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

    public function Route(string $method, string $url, string $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'url' => $url,
            'handler' => $handler
        ];
    }

    public function handleRoute(): void
    {
        $parts = explode(separator: '/', string: BASEURL);

        if ($specificPart = implode(separator: '/', array: array_slice(array: $parts, offset: 3))) {
            $url = '/' . ltrim(string: $_SERVER['REQUEST_URI'], characters: $specificPart . '/');
            $url = rtrim(string: $url, characters: '/');
        } else {
            $url = rtrim(string: $_SERVER['REQUEST_URI'], characters: '/');
        }

        $url = explode(separator: '?', string: $url)[0];
        $url_parts = explode(separator: '/', string: $url);
        $method_not_allowed = false;

        foreach ($this->routes as $route)
        {
            $route_parts = $this->parseURLFromRoute(routeUrl: $route['url']);

            if (count(value: $url_parts) === count(value: $route_parts)) {
                $parameters = [];
                $match = true;

                for ($i = 0; $i < count(value: $url_parts); $i++)
                {

                    if (!empty($route_parts[$i]) && $route_parts[$i][0] === '{' && $route_parts[$i][strlen(string: $route_parts[$i]) - 1] === '}') {
                        $parameter_name = substr(string: $route_parts[$i], offset: 1, length: -1);
                        $parameters[$parameter_name] = $url_parts[$i];
                    } elseif ($url_parts[$i] !== $route_parts[$i]) {
                        $match = false;
                        break;
                    }
                }

                if ($match) {

                    if ($_SERVER['REQUEST_METHOD'] === strtoupper(string: $route['method'])) {
                        $this->Controller(handler: $route['handler'], parameter: $parameters);
                        return;
                    } else {
                        $method_not_allowed = true;
                    }
                }
            }
        }

        if ($method_not_allowed) {
            header(header: "HTTP/1.0 405 Method Not Allowed");
            echo 'Method Not Allowed!';
        } else {
            header(header: "HTTP/1.0 404 Not Found");
            echo 'Not Found!';
        }
    }

    private function parseURLFromRoute(string $routeUrl): array|bool
    {
        $url = rtrim(string: $routeUrl, characters: '/');
        $url_parts = explode(separator: '/', string: $url);

        return $url_parts;
    }

    public function RoutesName(string $name, array $context = []): void
    {
        extract(array: $context);
        require_once('../app/config/Routes/' . $name . '.php');
    }
}
