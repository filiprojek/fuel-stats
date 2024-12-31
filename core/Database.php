<?php

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->initializeConnection();
        $this->checkAndCreateDatabase();
        $this->checkAndCreateTables();
    }

    /**
     * Get the singleton instance of the Database
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    /**
     * Get the active database connection
     * @return mysqli
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * Initialize the connection to the database
     */
    private function initializeConnection() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS);

        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }

    /**
     * Check and create the database if it doesn't exist
     */
    private function checkAndCreateDatabase() {
        $query = "CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "`";
        if (!$this->connection->query($query)) {
            die("Failed to create or access database: " . $this->connection->error);
        }

        $this->connection->select_db(DB_NAME);
    }

    /**
     * Check and create required tables if they don't exist
     */
    private function checkAndCreateTables() {
        // Create tables
        $usersTableQuery = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            points INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;";

        if (!$this->connection->query($usersTableQuery)) {
            die("Failed to create users table: " . $this->connection->error);
        }

        $vehiclesTableQuery = "
            CREATE TABLE IF NOT EXISTS vehicles (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                name VARCHAR(100) NOT NULL,
                registration_plate VARCHAR(50) NOT NULL UNIQUE,
                fuel_type ENUM('Diesel', 'Gasoline 95', 'Gasoline 98', 'Premium Diesel', 'Premium Gasoline 95', 'Premium Gasoline 98', 'Other') NOT NULL,
                note VARCHAR(150) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB;
        ";

        if (!$this->connection->query($vehiclesTableQuery)) {
            die("Failed to create vehicles table: " . $this->connection->error);
        }

        $refuelingTableQuery = "
            CREATE TABLE IF NOT EXISTS refueling_records (
                id INT AUTO_INCREMENT PRIMARY KEY,
                vehicle_id INT NOT NULL,
                fuel_type ENUM('Diesel', 'Gasoline 95', 'Gasoline 98', 'Premium Diesel', 'Premium Gasoline 95', 'Premium Gasoline 98', 'Other') NOT NULL,
                liters DECIMAL(10, 2) NOT NULL,
                price_per_liter DECIMAL(10, 2) NOT NULL,
                total_price DECIMAL(10, 2) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE
            ) ENGINE=InnoDB;
        ";

        if (!$this->connection->query($refuelingTableQuery)) {
            die("Failed to create refueling_records table: " . $this->connection->error);
        }

        /*
        // Create table_name table
        $usersTableQuery = "CREATE TABLE IF NOT EXISTS table_name (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;";

        if (!$this->connection->query($usersTableQuery)) {
            die("Failed to create table_name table: " . $this->connection->error);
        }
        */
    }

    /**
     * Prevent cloning of the singleton instance
     */
    private function __clone() {}

    /**
     * Prevent unserialization of the singleton instance
     */
    public function __wakeup() {}

}
