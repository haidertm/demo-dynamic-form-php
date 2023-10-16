<?php

namespace Haider\Demo;

use Haider\Demo\Core\Classes\Request;
use Haider\Demo\Core\Classes\Database;
use Haider\Demo\Api\Controllers\GreetingsController;

// add this line
class Router
{
    private $requestMethod;
    private $uri;
    private $db;

    private $routes = [];

    public function __construct($requestMethod, $uri, Database $db)
    {
        $this->requestMethod = $requestMethod;
        $this->uri = $uri;
        $this->db = $db;
    }

    public function get($path, $controller, $method = 'index', $route = null)
    {
        $routePath = $route === 'api' ? "/api" . $path : $path;
        $this->addRoute($routePath, $controller, $method, 'GET');
    }

    public function post($path, $controller, $method = 'index', $route = null)
    {
        $routePath = $route === 'api' ? "/api" . $path : $path;
        $this->addRoute($routePath, $controller, $method, 'POST');
    }


    public function addRoute($path, $controller, $method = 'index', $type = 'GET')
    {
        $this->routes[$type][$path] = [
            "controller" => $controller,
            "method" => $method
        ];
    }


    public function route()
    {

        if (array_key_exists($this->requestMethod, $this->routes) && array_key_exists($this->uri, $this->routes[$this->requestMethod])) {
            $route = $this->routes[$this->requestMethod][$this->uri];
            $controllerName = $route['controller'];
            $methodName = $route['method'];
            $controller = new $controllerName($this->db);
            // Create a new Request object
            $request = new Request();
            $controller->$methodName($request);
        } else {
            echo json_encode(["status" => "route_not_found"]);
        }
    }
}
