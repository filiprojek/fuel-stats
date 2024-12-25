<?php

class HomeController {
    //private function render($view) {
    //    ob_start();
    //    require_once views . $view;
    //    $content = ob_get_clean();
    //    require_once views . 'layouts/base.php';
    //}
    public function index() {
        $view = new View();
        $data = [
            'title' => 'Home'
        ];
        $view->render('home/index', $data);
        //require_once views . 'home/index.php';
    }
    
    public function home() {
        $this->index();
    }
}
