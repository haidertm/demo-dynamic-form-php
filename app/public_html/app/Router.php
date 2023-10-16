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
        $matchedRoute = null;
        $matches = []; // Declare an empty $matches array

        foreach ($this->routes[$this->requestMethod] as $routePath => $routeInfo) {
            $pattern = str_replace('/', '\/', $routePath);
            $pattern = '#^' . preg_replace('/:(\w+)/', '(?<$1>[^\/]+)', $pattern) . '$#'; // Escape '/' character within the pattern

            if (preg_match($pattern, $this->uri, $matches)) {
                $matchedRoute = $routeInfo;
                break;
            }
        }

        if ($matchedRoute) {
            $controllerName = $matchedRoute['controller'];
            $methodName = $matchedRoute['method'];
            $controller = new $controllerName($this->db);
            // Create a new Request object
            $request = new Request();

            // Pass route parameters to the Request object
            $request->setRouteParameters($matches);

            $controller->$methodName($request);
        } else {
            echo json_encode(["status" => "route_not_found"]);
        }
    }
}
