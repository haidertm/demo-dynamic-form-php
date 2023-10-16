<?php

namespace Haider\Demo\core\classes;

class Request
{

    private $routeParameters = [];

    public function setRouteParameters($parameters)
    {
        $this->routeParameters = $parameters;
    }

    public function getRouteParameter($name)
    {
        return $this->routeParameters[$name] ?? null;
    }

    public function allPost() {
        return $_POST;
    }

    public function allQuery() {
        return $_GET;
    }

    public function all() {
        return array_merge($_GET, $_POST);
    }

    public function has($key) {
        return isset($_POST[$key]) || isset($_GET[$key]);
    }

    public function hasPost($key) {
        return isset($_POST[$key]);
    }

    public function hasQuery($key) {
        return isset($_GET[$key]);
    }

    public function query($key, $default = null) {
        return $_GET[$key] ?? $default;
    }
    public function get($key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}