<?php
// Show errors and warnings
ini_set('display_errors', '1');
ini_set('log_errors', '1');
ini_set('error_log', '../storage/logs/error_log.log');

define('models', __DIR__ . '/../app/models/');
define('views', __DIR__ . '/../app/views/');
define('controllers', __DIR__ . '/../app/controllers/');

require_once '../core/Router.php';
require_once '../core/View.php';
require_once '../core/Controller.php';

// Initialize router
$router = new Router();
$router->add('/', 'HomeController@index');
$router->add('/home', 'HomeController@home');

// auth routes
$router->add('/auth/signin', 'AuthController@signin');
$router->add('/auth/signup', 'AuthController@signup');
$router->dispatch();
