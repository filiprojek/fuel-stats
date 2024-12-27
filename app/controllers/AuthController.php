<?php

class AuthController extends Controller  {
    public function signin() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $validator = new Validator();
            $validator->required('email', $email);
            $validator->email('email', $email);
            $validator->required('password', $password);

            if (!$validator->passes()) {
                $this->view('auth/signup', [
                    'error' => 'Please correct the errors below.',
                    'validationErrors' => $validator->errors() ?: [],
                ]);
                return;
            }

            $user = new User();
            $result = $user->login($email, $password);

            if($result === true) {
                $this->redirect('/dashboard');
            } else {
                $this->view('auth/signin', ['error' => $result], 'noheader');
            }
        } else {
            $this->view('auth/signin', ['title' => 'Log In'], 'noheader');
        }
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $password2 = $_POST['password-2'] ?? '';

            $validator = new Validator();
            $validator->required('username', $username);
            $validator->email('email', $email);
            $validator->required('password', $password);
            $validator->minLength('password', $password, 8);
            $validator->alphanumeric('password', $password);

            if ($password !== $password2) {
                $validator->errors()['password_confirmation'] = 'Passwords do not match.';
            }

            if (!$validator->passes()) {
                $this->view('auth/signup', [
                    'error' => 'Please correct the errors below.',
                    'validationErrors' => $validator->errors() ?: [],
                ], 'noheader');
                return;
            }

            $user = new User();
            $result = $user->register($username, $email, $password);

            if ($result === true) {
                $this->redirect('/auth/signin');
            } else {
                $this->view('auth/signup', [
                    'error' => $result,
                    'validationErrors' => [],
                ], 'noheader');
            }
        } else {
            $this->view('auth/signup', [
                'title' => 'Register',
                'validationErrors' => [],
            ], 'noheader');
        }
    }

    public function logout() {
        session_unset(); 
        session_destroy();
        $this->redirect('/auth/signin');
    }
}
