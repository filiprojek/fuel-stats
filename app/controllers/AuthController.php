<?php

class AuthController {
    public function signin() {
        $view = new View();
        $data = [
            'title' => 'Log In'
        ];
        $view->render('auth/signin', $data);
    }
    
    public function signup() {
        $view = new View();
        $data = [
            'title' => 'Register'
        ];
        $view->render('auth/signup', $data);
    }   
}
