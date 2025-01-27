<?php

class Refuel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        try{
            $stmt = $this->db->prepare("
                INSERT INTO refueling_records (user_id, vehicle_id, fuel_type, note, liters, price_per_liter, total_price, mileage, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            $stmt->bind_param(
                "iissdddi",
                $data['user_id'],
                $data['vehicle_id'],
                $data['fuel_type'],
                $data['note'],
                $data['liters'],
                $data['price_per_liter'],
                $data['total_price'],
                $data['mileage'],
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

    public function latest_data($vehicle_id, $record_count) {
        try {
            $stmt = $this->db->prepare("
                SELECT `liters`, `price_per_liter`, `total_price`, `mileage`, `created_at`
                FROM `refueling_records`
                WHERE `vehicle_id` = ?
                ORDER BY created_at DESC
                LIMIT ?;
            ");

            $stmt->bind_param("ii", $vehicle_id, $record_count);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
                return array_reverse($data);
            } else {
                return "Error: " . $stmt->error;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }

    public function latest_one($user_id, $record_count = 1) {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    `r`.`vehicle_id`, 
                    `v`.`name` AS `vehicle_name`, 
                    `r`.`liters`, 
                    `r`.`price_per_liter`, 
                    `r`.`total_price`, 
                    `r`.`mileage`, 
                    `r`.`created_at`
                FROM `refueling_records` AS `r`
                JOIN `vehicles` AS `v` ON `r`.`vehicle_id` = `v`.`id`
                WHERE `r`.`user_id` = ?
                ORDER BY `r`.`created_at` DESC
                LIMIT ?;
            ");

            $stmt->bind_param("ii", $user_id, $record_count);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $data = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
                return array_reverse($data);
            } else {
                return "Error: " . $stmt->error;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
    }
}
