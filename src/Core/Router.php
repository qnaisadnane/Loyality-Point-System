<?php
namespace App\Core;

class Router {
    private $routes = [];

    public function get($path, $controller, $method) {
        $this->routes[] = ['GET', $path, $controller, $method];
    }

    public function post($path, $controller, $method) {
        $this->routes[] = ['POST', $path, $controller, $method];
    }

    public function dispatch($uri, $httpMethod) {
        foreach ($this->routes as $route) {
            if ($route[0] === $httpMethod && $route[1] === $uri) {
                $controller = new $route[2]();
                $controller->{$route[3]}();
                return;
            }
        }
        http_response_code(404);
        echo "Page 404";
    }
}