<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] as $route => $callback) {
            $routePattern = preg_replace('/\{(.*?)\}/', '(.*?)', $route);
            if (preg_match("#^$routePattern$#", $uri, $matches)) {
                
                array_shift($matches);

                if (is_string($callback)) {
                    [$controller, $method] = explode('@', $callback);
                    $controller = "App\\Controllers\\$controller";
                    $instance = new $controller;
                    return call_user_func_array([$instance, $method], $matches);
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}