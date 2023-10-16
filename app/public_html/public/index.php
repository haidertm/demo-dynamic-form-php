<?php

// Include Composer's autoload file
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';
use Haider\Demo\Core\Classes\Database;
use Haider\Demo\Router;
use Haider\Demo\Api\Controllers\HomeController;
use Haider\Demo\Api\Controllers\DynamicForms;


// Create a Database object
$db = new Database();
$c = new HomeController();

// Create an instance of the Router
$router = new Router($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $db);

// Defining routes
$router->get(
    $path = '/',
    $controller = HomeController::class
);

// View for Showing list of all Created Forms
$router->get(
    $path = '/forms/list',
    $controller = DynamicForms::class,
    $method = 'list'
);

// Create/Add New form Page.
$router->get(
    $path = '/forms/add',
    $controller = DynamicForms::class,
    $method = 'add'
);

// Create/Add New form Page.
$router->get(
    $path = '/forms/preview/:formID',
    $controller = DynamicForms::class,
    $method = 'preview'
);

// Fetching Dynamic Component
$router->post(
    $path = '/forms/component/dynamic-form-input',
    $controller = DynamicForms::class,
    $method = 'dynamicFormInput'
);

// Define routes for /api routes
// Add Form to DB
$router->post(
    $path = '/forms/create',
    $controller = DynamicForms::class,
    $method = 'store',
    $route = 'api'
);

// View for Showing list of all Created Forms
$router->get(
    $path = '/forms/fetch',
    $controller = DynamicForms::class,
    $method = 'fetch',
    $route = 'api'
);

$router->route();