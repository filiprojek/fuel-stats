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
        // Create users table
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

        // Create progress table
        $progressTableQuery = "CREATE TABLE IF NOT EXISTS progress (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            habit_id INT NOT NULL,
            date DATE NOT NULL,
            status ENUM('Done', 'Pending') DEFAULT 'Pending',
            FOREIGN KEY (user_id) REFERENCES users(id)
        ) ENGINE=InnoDB;";

        if (!$this->connection->query($progressTableQuery)) {
            die("Failed to create progress table: " . $this->connection->error);
        }

        
        // Create habits table
        $habitsTableQuery = "CREATE TABLE IF NOT EXISTS habits (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            title VARCHAR(100) NOT NULL,
            frequency ENUM('Daily', 'Weekly', 'Custom') NOT NULL,
            custom_frequency VARCHAR(255) DEFAULT NULL, -- Store crontab-like string
            reward_points INT DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB;";

        if (!$this->connection->query($habitsTableQuery)) {
            die("Failed to create habits table: " . $this->connection->error);
        }
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
