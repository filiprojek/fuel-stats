<?php

class Vehicle {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        try{
            $stmt = $this->db->prepare("
                INSERT INTO vehicles (user_id, name, registration_plate, fuel_type, note, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");

            $stmt->bind_param(
                "issss",
                $data['user_id'],
                $data['name'],
                $data['registration_plate'],
                $data['fuel_type'],
                $data['note'],
            );

            if ($stmt->execute()) {
                return true;
            } else {
                return "Error: " . $stmt->error;
            }
        } catch(mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }

    public function getVehiclesByUser($userId) {
        $stmt = $this->db->prepare("SELECT id, name, registration_plate, fuel_type, note, created_at FROM vehicles WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $vehicles = [];
        while ($row = $result->fetch_assoc()) {
            $vehicles[] = $row;
        }
        
        return $vehicles;
    }
}
