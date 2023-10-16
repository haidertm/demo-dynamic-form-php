<?php

require_once __DIR__ . '/../vendor/autoload.php';


use core\classes\Database;
use Haider\Demo\Api\Controllers\GreetingsController;

//use Haider\Demo\Core\Classes\Database;

// Create a Database object
$db = new Database();
$controller = new GreetingsController();
$controller->list();

//var_dump($db);
//require_once 'DynamicFormController.php';

//$requestMethod = $_SERVER['REQUEST_METHOD'];
//$uri = $_SERVER['REQUEST_URI'];
//
//$router = new Router($requestMethod, $uri, $db);
//
//$router->addRoute('/greetings', GreetingsController::class, 'sayHello');
//$router->addRoute('/dynamic-form/add', DynamicForms::class, 'list');

//$router->route();
