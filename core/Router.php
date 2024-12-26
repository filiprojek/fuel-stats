<?php

class Router {
    private $routes = [];
    private $middlewares = [];
    private $groupPrefix = '';
    private $groupMiddlewares = [];

    /**
     * Add a route with a specific action and optional middleware
     * 
     * @param string $route
     * @param string $action
     * @param array $middlewares Optional middlewares for this route
     */
    public function add($route, $action, $middlewares = []) {
        $route = $this->groupPrefix . $route;
        $middlewares = array_merge($this->groupMiddlewares, $middlewares);
        $this->routes[$route] = ['action' => $action, 'middlewares' => $middlewares];
    }

    /**
     * Define a group of routes with shared prefix and middlewares
     * 
     * @param string $prefix
     * @param array $middlewares
     * @param callable $callback
     */
    public function group($prefix, $middlewares, $callback) {
        // Save the current state
        $previousPrefix = $this->groupPrefix;
        $previousMiddlewares = $this->groupMiddlewares;

        // Set new group prefix and middlewares
        $this->groupPrefix = $previousPrefix . $prefix;
        $this->groupMiddlewares = array_merge($this->groupMiddlewares, $middlewares);

        // Execute the callback to define routes in the group
        $callback($this);

        // Restore the previous state
        $this->groupPrefix = $previousPrefix;
        $this->groupMiddlewares = $previousMiddlewares;
    }

    /**
     * Dispatch the current request to the correct route and execute middlewares
     */
    public function dispatch() {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($uri, PHP_URL_PATH);

        // Normalize the URI by removing trailing slash (except for root "/")
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }

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
