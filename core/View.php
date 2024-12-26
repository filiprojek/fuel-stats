<?php
class View
{
    private $data = [];

    public function render($view, $data = [], $layout = 'base') {
        // Store the data 
        $this->data = $data;

        // Capture the view content
        ob_start();
        require_once views . $view . '.php';
        $content = ob_get_clean();

        // Include the base layout and inject the view content
        require_once views . "layouts/$layout.php";
    }

    /**
     * Safely get a value from the data array
     */
    public function get($key) {
        return $this->data[$key] ?? null;
    }
}
