<?php

class AuthController extends Controller  {
    public function signin() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = new User();
            $result = $user->login($email, $password);

            if($result === true) {
                $this->redirect('/dashboard');
            } else {
                $this->view('auth/signin', ['error' => $result]);
            }
        } else {
            $this->view('auth/signin', ['title' => 'Log In']);
        }
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $password2 = $_POST['password-2'] ?? '';

            // Perform validations
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
                ]);
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
                ]);
            }
        } else {
            $this->view('auth/signup', [
                'title' => 'Register',
                'validationErrors' => [],
            ]);
        }
    }
}
