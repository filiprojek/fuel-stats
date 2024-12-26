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

// Initialize router
$router = new Router();
$router->add('/', 'HomeController@index');
$router->add('/home', 'HomeController@home');

// auth routes
$router->group('/auth', [], function ($router) {
    $router->add('/signin', 'AuthController@signin');
    $router->add('/signup', 'AuthController@signup');
    $router->add('/logout', 'AuthController@logout');
});

// dashboard route
$router->add('/dashboard', 'HomeController@dashboard', ['RequireAuth']);

// habits routes
$router->group('/habits', ['RequireAuth'], function ($router) {
    $router->add('', 'HabitController@index');
    $router->add('/create', 'HabitController@create');
    $router->add('/edit/{id}', 'HabitController@edit');
    $router->add('/delete/{id}', 'HabitController@delete');
});

$router->dispatch();
