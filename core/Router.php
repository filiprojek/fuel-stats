<?php

class Router {
    private $routes = [];

    public function add($route, $action) {
        $this->routes[$route] = $action;
    }

    public function dispatch() {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($uri, PHP_URL_PATH);

        if (array_key_exists($uri, $this->routes)) {
            $action = $this->routes[$uri];
            list($controllerName, $methodName) = explode('@', $action);

            require_once controllers . "{$controllerName}.php";

            $controller = new $controllerName();
            $controller->$methodName();
        } else {
            http_response_code(404);
            $view = new View();
            $view->render('errors/404');
        }
    }
}
