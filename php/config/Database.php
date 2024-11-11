<?php
require_once __DIR__ . '/Logger.php';

class Database {
    private static $instance = null;
    private $connection = null;
    private $logger;
    private $dbPath;

    private function __construct($dbPath) {
        $this->logger = Logger::getInstance();
        $this->dbPath = $dbPath;
        $this->connect();
    }

    public static function getInstance($dbPath = null) {
        if (self::$instance === null) {
            if ($dbPath === null) {
                $dbPath = getenv('DB_PATH');
                if (!$dbPath) {
                    throw new Exception('DB_PATH environment variable is not set');
                }
            }
            self::$instance = new self($dbPath);
        }
        return self::$instance;
    }

    private function connect() {
        try {
            $this->logger->log("Connecting to database at path: " . $this->dbPath);
            
            // Create directory if it doesn't exist
            $dbDir = dirname($this->dbPath);
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0777, true);
            }
            
            $this->connection = new SQLite3($this->dbPath);
            $this->connection->enableExceptions(true);
            
            $this->logger->log("Database connection established successfully");
        } catch (Exception $e) {
            $this->logger->logError("Database connection failed for path: " . $this->dbPath, $e);
            throw $e;
        }
    }

    public function query($sql, $params = []) {
        try {
            $this->logger->logSQL($sql, $params);
            
            $stmt = $this->connection->prepare($sql);
            
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            
            $result = $stmt->execute();
            $rows = [];
            
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rows[] = $row;
            }
            
            $result->finalize();
            $this->logger->logSQL($sql, $params, $rows);
            
            return $rows;
        } catch (Exception $e) {
            $this->logger->logError("Query execution failed", $e);
            throw $e;
        }
    }

    public function execute($sql, $params = []) {
        try {
            $this->logger->logSQL($sql, $params);
            
            $stmt = $this->connection->prepare($sql);
            
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            
            $result = $stmt->execute();
            $this->logger->logSQL($sql, $params, "Statement executed");
            
            return $result;
        } catch (Exception $e) {
            $this->logger->logError("Statement execution failed", $e);
            throw $e;
        }
    }

    public function getLastInsertId() {
        return $this->connection->lastInsertRowID();
    }

    public function beginTransaction() {
        $this->logger->log("Beginning transaction", "TRANSACTION");
        return $this->connection->exec('BEGIN TRANSACTION');
    }

    public function commit() {
        $this->logger->log("Committing transaction", "TRANSACTION");
        return $this->connection->exec('COMMIT');
    }

    public function rollback() {
        $this->logger->log("Rolling back transaction", "TRANSACTION");
        return $this->connection->exec('ROLLBACK');
    }

    public function getConnection() {
        return $this->connection;
    }
}
