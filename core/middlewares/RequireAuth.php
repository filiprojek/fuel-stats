<?php

class RequireAuth {
    public function handle() {
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/signin');
            exit();
        }

        return true;
    }
}
