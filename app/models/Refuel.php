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
            $sql = "
                SELECT `liters`, `price_per_liter`, `total_price`, `mileage`, `created_at`
                FROM `refueling_records`
                WHERE `vehicle_id` = ?
                ORDER BY created_at DESC";

            if ($record_count > 0) {
                $sql .= " LIMIT ?";
            }

            $stmt = $this->db->prepare($sql);

            if ($record_count > 0) {
                $stmt->bind_param("ii", $vehicle_id, $record_count);
            } else {
                $stmt->bind_param("i", $vehicle_id);
            }

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

    public function latest_one($vehicle_id, $record_count = 1) {
        try {
            $sql = "
                SELECT 
                    `r`.`vehicle_id`, 
                    `v`.`name` AS `vehicle_name`, 
                    `r`.`liters`, 
                    `r`.`price_per_liter`, 
                    `r`.`total_price`, 
                    `r`.`mileage`, 
                    `r`.`note`, 
                    `r`.`created_at`
                FROM `refueling_records` AS `r`
                JOIN `vehicles` AS `v` ON `r`.`vehicle_id` = `v`.`id`
                WHERE `r`.`vehicle_id` = ?
                ORDER BY `r`.`created_at` DESC";

            if ($record_count > 0) {
                $sql .= " LIMIT ?";
            }

            $stmt = $this->db->prepare($sql);

            if ($record_count > 0) {
                $stmt->bind_param("ii", $vehicle_id, $record_count);
            } else {
                $stmt->bind_param("i", $vehicle_id);
            }

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
