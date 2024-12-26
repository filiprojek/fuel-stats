<?php

class Router {
    private $routes = [];
    private $middlewares = [];

    /**
     * Add a route with a specific action and optional middleware
     * 
     * @param string $route
     * @param string $action
     * @param array $middlewares Optional middlewares for this route
     */
    public function add($route, $action, $middlewares = []) {
        $this->routes[$route] = ['action' => $action, 'middlewares' => $middlewares];
    }

    /**
     * Dispatch the current request to the correct route and execute middlewares
     */
    public function dispatch() {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($uri, PHP_URL_PATH);

        if (array_key_exists($uri, $this->routes)) {
            $route = $this->routes[$uri];
            $middlewares = $route['middlewares'];

            // Execute middlewares
            foreach ($middlewares as $middleware) {
                $middlewareInstance = new $middleware();
                if (!$middlewareInstance->handle()) {
                    return; // Stop execution if middleware fails
                }
            }

            // Execute the route's controller and method
            $action = $route['action'];
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
