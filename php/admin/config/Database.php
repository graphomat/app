<?php

require_once __DIR__ . '/env.php';

class AdminDatabase {
    private static $instance = null;
    private $db;

    private function __construct() {
        $dbPath = dirname(__DIR__) . '/' . Environment::get('DB_PATH', 'admin.sqlite');
        $dbDir = dirname($dbPath);
        
        // Create database directory if it doesn't exist
        if (!file_exists($dbDir)) {
            mkdir($dbDir, 0755, true);
        }

        try {
            $this->db = new SQLite3($dbPath);
            $this->db->enableExceptions(true);
            
            // Set pragmas for better performance and security
            $this->db->exec('PRAGMA journal_mode=WAL');
            $this->db->exec('PRAGMA foreign_keys=ON');
        } catch (Exception $e) {
            error_log('Database connection error: ' . $e->getMessage());
            throw new Exception('Database connection failed');
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new AdminDatabase();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->db;
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->db->prepare($sql);
            
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            
            $result = $stmt->execute();
            return $result;
        } catch (Exception $e) {
            error_log('Query error: ' . $e->getMessage());
            throw new Exception('Query execution failed');
        }
    }

    public function changes() {
        return $this->db->changes();
    }

    public function lastInsertRowID() {
        return $this->db->lastInsertRowID();
    }

    public function close() {
        if ($this->db) {
            $this->db->close();
        }
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserializing of the instance
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}
