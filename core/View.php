<?php
class View
{
    public function render($view, $data = [], $layout = 'base')
    {
        // Extract variables to be accessible in the view
        extract($data);

        // Capture the view content
        ob_start();
        require_once views . $view . '.php';
        $content = ob_get_clean();

        // Include the base layout and inject the view content
        require_once  views . "layouts/$layout.php";
    }
}
