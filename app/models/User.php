<?php

require_once '../core/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();

        if ($this->db) {
            error_log("Database connection established successfully.");
        } else {
            error_log("Failed to connect to the database.");
        }
    }

    public function register($username, $email, $password) {
        // Check if email already exists
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            return "Email is already registered";
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Error: " . $stmt->error;
        }
    }

    public function login($email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $email,
                ];
                return true;
            } 
        } 

        return "Incorrect username or password.";
    }
}
