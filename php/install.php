<?php
require_once __DIR__ . '/config/Database.php';

class Installer
{
    private $db;
    private $files = [];
    private $errors = [];
    private $sectionsDir = __DIR__ . '/sections';
    private $installedTables = [];

    public function __construct()
    {
        try {
            $this->db = Database::getInstance();
        } catch (Exception $e) {
            $this->errors[] = "Database connection error: " . $e->getMessage();
        }
    }

    public function installData($file)
    {
        try {
            // Load and execute main schema first
            $this->executeSchema(__DIR__ . "/" . $file);

            return empty($this->errors);
        } catch (Exception $e) {
            $this->errors[] = "Installation error: " . $e->getMessage();
            return false;
        }
    }

    public function installModules($file)
    {
        try {
            // Load and execute main schema first
//            $this->executeSchema(__DIR__ . "/" . $file);

            // Load and execute section schemas only
            $this->loadSectionSchemas();

            return empty($this->errors);
        } catch (Exception $e) {
            $this->errors[] = "Installation error: " . $e->getMessage();
            return false;
        }
    }


    private function executeSchema($schemaPath)
    {
        if (!file_exists($schemaPath)) {
            throw new Exception("Schema file not found: $schemaPath");
        }

        $sql = file_get_contents($schemaPath);
        if ($sql === false) {
            throw new Exception("Could not read schema file: $schemaPath");
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
                // Skip empty statements
                if (empty(trim($statement))) {
                    continue;
                }

                // Handle CREATE TABLE statements
                if (stripos($statement, 'CREATE TABLE') === 0) {
                    preg_match('/CREATE TABLE (?:IF NOT EXISTS )?[`"]?(\w+)[`"]?/i', $statement, $matches);
                    if (!empty($matches[1])) {
                        $tableName = $matches[1];
                        if (isset($this->installedTables[$tableName])) {
                            continue; // Skip if table was already created
                        }
                        $this->installedTables[$tableName] = true;
                    }
                }

                // Handle INSERT statements
                if (stripos($statement, 'INSERT INTO') === 0) {
                    // Convert INSERT INTO to INSERT OR IGNORE INTO
                    $statement = preg_replace(
                        '/^INSERT INTO/i',
                        'INSERT OR IGNORE INTO',
                        $statement
                    );
                }

                $this->db->getConnection()->exec($statement);
            } catch (Exception $e) {
                // Skip "table already exists" errors
                if (!strpos($e->getMessage(), 'already exists')) {
                    $this->errors[] = "SQL Error: " . $e->getMessage() . "\nStatement: $statement";
                }
            }
        }
    }

    private function loadSectionSchemas()
    {
        if (!is_dir($this->sectionsDir)) {
            throw new Exception("Sections directory not found");
        }

        $sections = array_filter(glob($this->sectionsDir . '/*'), 'is_dir');

        foreach ($sections as $sectionDir) {
            // Only process directories that are direct sections (skip integrations)
            if (basename(dirname($sectionDir)) === 'sections') {
                $schemaPath = $sectionDir . '/schema.sql';
                if (file_exists($schemaPath)) {
                    $this->executeSchema($schemaPath);
                }
            }
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}

// Run installation
$installer1 = new Installer();
$success1 = $installer1->installData('schema.sql');

$installer2 = new Installer();
$success2 = $installer2->installModules('schema.sql');

$installer3 = new Installer();
$success3 = $installer3->installData('index.sql');


// Output results
header('Content-Type: application/json');
echo json_encode(
    [
        'success' => $success1,
        'errors' => $installer1->getErrors()
    ],
    [
        'success' => $success2,
        'errors' => $installer2->getErrors()
    ],
    [
        'success' => $success3,
        'errors' => $installer3->getErrors()
    ]
);
