<?php

class Refuel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        try{
            $stmt = $this->db->prepare("
                INSERT INTO refueling_records (user_id, vehicle_id, fuel_type, note, liters, price_per_liter, total_price, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            $stmt->bind_param(
                "iissddd",
                $data['user_id'],
                $data['vehicle_id'],
                $data['fuel_type'],
                $data['note'],
                $data['liters'],
                $data['price_per_liter'],
                $data['total_price'],
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
}
