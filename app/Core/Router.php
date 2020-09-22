<?php
namespace App\Core;

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    public static function load($file)
    {
        $router = new self;
        require $file;
        return $router;
    }

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType)
    {
        if(array_key_exists($uri, $this->routes[$requestType]))
        {
            return $this->callMethod(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }
        throw new \Exception('Not a valid URI');
    }

    public function callMethod($controller, $method)
    {
        $controller = "\\App\\Controller\\{$controller}";
        $controller = new $controller;

        if(!method_exists($controller, $method)){
            throw new \Exception("{$method} does not exists in {$controller} class");
        }

        return $controller->$method();
    }
}