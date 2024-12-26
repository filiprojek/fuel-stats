<?php

class HomeController extends Controller {
    public function index() {
        $data = [
            'title' => 'Home'
        ];
        $this->view('home/index', $data);
    }
    
    public function home() {
        $this->index();
    }

    public function dashboard() {
        $this->view("dashboard/index");
    }
}
