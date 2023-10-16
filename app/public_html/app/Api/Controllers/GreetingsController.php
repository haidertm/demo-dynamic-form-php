<?php

namespace Haider\Demo\Api\Controllers;

class GreetingsController extends Controller {
    public function __construct() {
    }

    public function sayHello() {
        echo json_encode(["message" => "Hello, World!"]);
    }
}
