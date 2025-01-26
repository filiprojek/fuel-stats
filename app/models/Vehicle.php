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

    public function getVehiclesByUser($user_id) {
        $stmt = $this->db->prepare("SELECT id, name, registration_plate, fuel_type, note, created_at FROM vehicles WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $vehicles = [];
        while ($row = $result->fetch_assoc()) {
            $vehicles[] = $row;
        }
        
        return $vehicles;
    }

    public function getDefaultVehicle($user_id) {
        $stmt = $this->db->prepare("
            SELECT id, name, registration_plate, fuel_type, note, is_default
            FROM vehicles
            WHERE user_id = ? AND is_default = TRUE
            LIMIT 1
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function setDefaultVehicle($vehicle_id, $user_id) {
        try {
            $this->db->begin_transaction();

            $stmt = $this->db->prepare("
                UPDATE `vehicles` 
                SET `is_default` = 0 
                WHERE `user_id` = ? AND `is_default` = 1
            ");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();

            $stmt = $this->db->prepare("
                UPDATE `vehicles` 
                SET `is_default` = 1 
                WHERE `id` = ? AND `user_id` = ?
            ");
            $stmt->bind_param("ii", $vehicle_id, $user_id);

            if ($stmt->execute()) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollback();
                return "Error: " . $stmt->error;
            }
        } catch (mysqli_sql_exception $e) {
            $this->db->rollback();
            return $e->getMessage();
        }
    }

    public function delete($vehicle_id, $user_id) {
        try {
            $stmt = $this->db->prepare("SELECT id FROM vehicles WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $vehicle_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                return "Error: Unauthorized action or vehicle not found.";
            }

            $stmt = $this->db->prepare("DELETE FROM vehicles WHERE id = ?");
            $stmt->bind_param("i", $vehicle_id);

            if ($stmt->execute()) {
                return true;
            } else {
                return "Error: " . $stmt->error;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
}
