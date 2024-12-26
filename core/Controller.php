<?php
class Controller {
    /**
     * Redirect to a given URL
     *
     * @param string $url
     */
    public function redirect($url) {
        header("Location: $url");
        exit();
    }

    /**
     * Render a view
     *
     * @param string $viewName
     * @param array $data
     */
    public function view($viewName, $data = []) {
        $view = new View();
        $view->render($viewName, $data);
    }
}
