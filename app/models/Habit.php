<?php

class Habit {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO habits (user_id, title, frequency, custom_frequency, reward_points, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "isssi", // Bind types: int, string, string, string, int
            $data['user_id'],
            $data['name'],
            $data['frequency'],
            $data['custom_frequency'], // Bind the custom_frequency field
            $data['reward_points']
        );

        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Failed to create habit: " . $stmt->error);
            return false;
        }
    }
}
