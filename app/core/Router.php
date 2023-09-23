<?php

class Routing
{

    private $routes = [];

    private function Controller($handler)
    {

        $split_handler = explode("::", $handler);

        $controller_file = '../app/controllers/' . $split_handler[0] . '.php';

        require_once($controller_file);

        $className = $split_handler[0];
        $class = new $className();

        $functionName = $split_handler[1];
        $class->$functionName();

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

        foreach ($this->routes as $route) {

            if ($_SERVER['REQUEST_METHOD'] === strtoupper($route['method']) && $_SERVER['REQUEST_URI'] === $route['url']) {

                $this->Controller($route['handler']);
                return;

            }

        }

        header("HTTP/1.0 404 Not Found");
        echo 'Not Found!';
    }

}