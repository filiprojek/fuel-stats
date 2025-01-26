<?php
// Show errors and warnings
session_start();
ini_set('display_errors', '1');
ini_set('log_errors', '1');
ini_set('error_log', '../storage/logs/error_log.log');

define('models', __DIR__ . '/../app/models/');
define('views', __DIR__ . '/../app/views/');
define('controllers', __DIR__ . '/../app/controllers/');
define('config', __DIR__ . '/../config/');

require_once config . 'environment.php';

require_once '../core/Validator.php';
require_once '../core/Router.php';
require_once '../core/View.php';
require_once '../core/Controller.php';
require_once '../core/Database.php';
require_once '../core/middlewares/RequireAuth.php';

require_once models . 'User.php';
require_once models . 'Vehicle.php';
require_once models . 'Refuel.php';

// Initialize router
$router = new Router();
if(!isset($_SESSION['user'])) {
    $router->add('/', 'HomeController@index');
} else {
    $router->add('/', 'DashboardController@reroute', ['RequireAuth']);
}

// auth routes
$router->group('/auth', [], function ($router) {
    $router->add('/signin', 'AuthController@signin');
    $router->add('/signup', 'AuthController@signup');
    $router->add('/logout', 'AuthController@logout');
});

// dashboard route
$router->add('/dashboard', 'DashboardController@index', ['RequireAuth']);

// vehicle routes
$router->group('/vehicles', ['RequireAuth'], function ($router) {
    $router->add('', 'VehicleController@index');
    $router->add('/create', 'VehicleController@create');
    $router->add('/edit/{id}', 'VehicleController@edit');
    $router->add('/delete/{id}', 'VehicleController@delete');
});

$router->group('/refuel', ['RequireAuth'], function ($router) {
    $router->add('/create', 'RefuelController@create');
});

// API
$router->group('/api/v1', ['RequireAuth'], function ($router) {
    $router->add('/vehicles/get', 'VehicleController@api_get');
});

$router->dispatch();
