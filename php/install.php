<?php
require_once __DIR__ . '/config/env.php';
require_once __DIR__ . '/config/Logger.php';
require_once __DIR__ . '/config/Database.php';

$logger = Logger::getInstance();
$logger->log("Starting database installation...");

try {
    // Ensure DB_PATH is set
    if (!getenv('DB_PATH')) {
        throw new Exception('DB_PATH environment variable is not set');
    }
    
    $dbPath = getenv('DB_PATH');
    $logger->log("Using database path: $dbPath");

    // Ensure database directory exists
    $dbDir = dirname($dbPath);
    if (!is_dir($dbDir)) {
        $logger->log("Creating database directory: $dbDir");
        mkdir($dbDir, 0777, true);
    }
    
    // Get database instance with explicit path
    $db = Database::getInstance($dbPath);
    
    // Drop existing tables in reverse order to handle foreign key constraints
    $logger->log("Dropping existing tables...");
    $tables = [
        'certification_instructors',
        'certification_details',
        'team_members',
        'meta',
        'menu_categories',
        'menu_items',
        'config',
        'sections',
        'pages',
        'sites'
    ];
    
    foreach ($tables as $table) {
        $db->execute("DROP TABLE IF EXISTS $table");
    }
    
    // First, create all tables from all schema files
    $logger->log("Creating main database schema...");
    $schema = file_get_contents(__DIR__ . '/schema.sql');
    $statements = explode(';', $schema);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $db->execute($statement);
        }
    }

    // Load and execute all section schemas to create tables
    $logger->log("Loading section schemas...");
    $sectionSchemas = glob(__DIR__ . '/sections/*/schema.sql');
    foreach ($sectionSchemas as $schemaFile) {
        $logger->log("Loading schema: " . basename(dirname($schemaFile)));
        $schema = file_get_contents($schemaFile);
        $statements = explode(';', $schema);
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                if (stripos($statement, 'CREATE TABLE') !== false || stripos($statement, 'CREATE INDEX') !== false) {
                    $db->execute($statement);
                }
            }
        }
    }
    
    // Then, execute all other statements (inserts, etc.)
    foreach ($sectionSchemas as $schemaFile) {
        $schema = file_get_contents($schemaFile);
        $statements = explode(';', $schema);
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                if (stripos($statement, 'CREATE TABLE') === false && stripos($statement, 'CREATE INDEX') === false) {
                    $db->execute($statement);
                }
            }
        }
    }
    
    // Finally, read and execute initial data
    $logger->log("Inserting initial data...");
    $initialData = file_get_contents(__DIR__ . '/index.sql');
    $statements = explode(';', $initialData);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $db->execute($statement);
        }
    }
    
    $logger->log("Database installation completed successfully");
    echo "Database installation completed successfully at: " . $dbPath . "\n";
    
} catch (Exception $e) {
    $logger->logError("Installation failed", $e);
    echo "Installation failed: " . $e->getMessage() . "\n";
}
