<?php

namespace App\Core;

use App\Controllers;

class Router
{

    private $routes = [];
    private $globalMiddlewares = [];
    private $groupPrefix = '';
    private $groupMiddleware = [];

    private function Controller(string $handler, array $parameter = []): void
    {
        $split_handler = explode(separator: "::", string: $handler);
        $controller_file = '../app/controllers/' . $split_handler[0] . '.php';

        require_once($controller_file);

        $parts = explode(separator: "/", string: $split_handler[0]);

        $className = 'App\\Controllers\\' . end(array: $parts);
        $class = new $className();

        $functionName = $split_handler[1];

        if (!empty($parameter)) {
            $class->$functionName($parameter);
        } else {
            $class->$functionName();
        }
    }

    public function Route(string $method, string $url, string|callable $handler, array $middlewares = []): void
    {
        if ($this->groupPrefix) {
            $url = '/' . trim(string: $this->groupPrefix, characters: '/') . '/' . ltrim(string: $url, characters: '/');
        }

        $middlewares = array_merge($this->groupMiddleware, $middlewares);

        $this->routes[] = [
            'method' => $method,
            'url' => $url,
            'handler' => $handler,
            'middlewares' => $middlewares
        ];
    }

    public function handleRoute(): void
    {
        $parts = (DEV_MODE) ? explode(separator: '/', string: DEV_BASEURL) : explode(separator: '/', string: BASEURL);

        if ($specificPart = implode(separator: '/', array: array_slice(array: $parts, offset: 3))) {
            $url = $_SERVER['REQUEST_URI'];
            
            if (!empty($specificPart)) {
                $url = '/' . ltrim(string: str_replace(search: $specificPart, replace: '', subject: $url), characters: '/');
            }

            // $url = '/' . ltrim(string: $_SERVER['REQUEST_URI'], characters: $specificPart . '/');
            $url = rtrim(string: $url, characters: '/');
        } else {
            $url = rtrim(string: $_SERVER['REQUEST_URI'], characters: '/');
        }

        $url = explode(separator: '?', string: $url)[0];
        $url_parts = explode(separator: '/', string: $url);

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            $allowed_methods = [];
            foreach ($this->routes as $route) {
                $route_parts = $this->parseURLFromRoute(routeUrl: $route['url']);
                if (count(value: $url_parts) === count(value: $route_parts)) {
                    $match = true;
                    for ($i = 0; $i < count(value: $url_parts); $i++) {
                        if (!empty($route_parts[$i]) && $route_parts[$i][0] === '{' && $route_parts[$i][strlen(string: $route_parts[$i]) - 1] === '}') continue;
                        if ($url_parts[$i] !== $route_parts[$i]) { $match = false; break; }
                    }
                    if ($match) $allowed_methods[] = strtoupper(string: $route['method']);
                }
            }

            if (!empty($allowed_methods)) {
                header(header: "Access-Control-Allow-Origin: *");
                header(header: "Access-Control-Allow-Methods: " . implode(separator: ',', array: $allowed_methods));
                header(header: "Access-Control-Allow-Headers: *");
                http_response_code(response_code: 204);
            } else {
                header(header: "HTTP/1.0 405 Method Not Allowed");
                echo 'Method Not Allowed!';
            }

            exit;
        }
        
        $method_not_allowed = false;

        foreach ($this->globalMiddlewares as $middleware) {
            $this->executeMiddleware(middleware: $middleware['middleware'], constructParams: $middleware['constructParams'], function: $middleware['function'], params: $middleware['params']);
        }

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

                    foreach ($route['middlewares'] as $middleware) {
                        $this->executeMiddleware(middleware: $middleware['middleware'], constructParams: $middleware['constructParams'], function: $middleware['function'], params: $middleware['params']);
                    }

                    if ($_SERVER['REQUEST_METHOD'] === strtoupper(string: $route['method'])) {
                        if (is_callable(value: $route['handler'])) {
                            $request = new \App\Core\Request();
                            $response = new \App\Core\Response();
                            call_user_func_array(callback: $route['handler'], args: [$request, $response, $parameters]);
                        } elseif (is_string(value: $route['handler'])) {
                            $this->Controller(handler: $route['handler'], parameter: $parameters);
                        }
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

    public function Group(string $prefix, array $middlewares, \Closure $callback): void
    {
        $previousPrefix = $this->groupPrefix;
        $previousMiddleware = $this->groupMiddleware;

        $this->groupPrefix = ($prefix === "/") ? "" : $prefix;
        $this->groupMiddleware = array_merge($this->groupMiddleware, $middlewares);

        $callback($this);

        $this->groupPrefix = $previousPrefix;
        $this->groupMiddleware = $previousMiddleware;
    }

    public function Middleware(string $middleware, array $constructParams, string $function = 'handle', array $params = []): void
    {
        $this->globalMiddlewares[] = [
            'middleware' => $middleware,
            'constructParams' => $constructParams,
            'function' => $function,
            'params' => $params
        ];
    }

    private function executeMiddleware(string $middleware, array $constructParams, string $function, array $params): void
    {

        $middlewareFile = '../app/middleware/' . $middleware . '.php';
        require_once($middlewareFile);

        $className = 'App\\Middleware\\' . $middleware;

        if (class_exists(class: $className)) {

            if ($constructParams) {
                $middlewareInstance = new $className(...$constructParams);
            } else {
                $middlewareInstance = new $className();
            }

            if (method_exists(object_or_class: $middlewareInstance, method: $function)) {
                call_user_func_array(callback: [$middlewareInstance, $function], args: $params);
            } else {
                echo "Method $function not found in middleware $middleware.";
                exit;
            }
        } else {
            echo "Middleware not found!";
            exit;
        }
    }
}
