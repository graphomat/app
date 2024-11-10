<?php
require_once __DIR__ . '/config/Database.php';

class AdminInstaller {
    private $db;
    private $errors = [];

    public function __construct() {
        try {
            $this->db = AdminDatabase::getInstance();
        } catch (Exception $e) {
            $this->errors[] = "Database connection error: " . $e->getMessage();
        }
    }

    public function install() {
        try {
            // Create admin tables
            $this->executeSchema();
            return empty($this->errors);
        } catch (Exception $e) {
            $this->errors[] = "Installation error: " . $e->getMessage();
            return false;
        }
    }

    private function executeSchema() {
        // Read schema file
        $schemaPath = __DIR__ . '/schema.sql';
        if (!file_exists($schemaPath)) {
            throw new Exception("Schema file not found: $schemaPath");
        }

        $sql = file_get_contents($schemaPath);
        if ($sql === false) {
            throw new Exception("Failed to read schema file");
        }

        // Split SQL into individual statements
        $statements = array_filter(
            array_map(
                'trim',
                explode(';', $sql)
            ),
            'strlen'
        );

        foreach ($statements as $statement) {
            try {
                $this->db->getConnection()->exec($statement);
            } catch (Exception $e) {
                // Skip "table already exists" errors
                if (!strpos($e->getMessage(), 'already exists')) {
                    $this->errors[] = "SQL Error: " . $e->getMessage() . "\nStatement: $statement";
                }
            }
        }
    }

    public function getErrors() {
        return $this->errors;
    }
}

// Run installation
$installer = new AdminInstaller();
$success = $installer->install();

// Output results
header('Content-Type: application/json');
echo json_encode([
    'success' => $success,
    'errors' => $installer->getErrors()
]);
