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
    
    // First, create all tables from main schema file
    $schemaFile = __DIR__ . '/schema.sql';
    $logger->logSqlFile($schemaFile, 'Loading main schema');
    $schema = file_get_contents($schemaFile);
    $statements = explode(';', $schema);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $db->execute($statement);
        }
    }

    // Load and execute all section schemas
    $logger->log("Loading section schemas...");
    $sectionSchemas = glob(__DIR__ . '/sections/*/schema.sql');
    
    // First pass: Create all tables
    foreach ($sectionSchemas as $schemaFile) {
        $logger->logSqlFile($schemaFile, 'Creating tables from section schema');
        $schema = file_get_contents($schemaFile);
        
        // Split on semicolons but keep them in the statements
        $statements = preg_split('/(?<=[;])/', $schema, -1, PREG_SPLIT_NO_EMPTY);
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                // Execute CREATE TABLE and CREATE INDEX statements
                if (preg_match('/^\s*CREATE\s+(?:TABLE|INDEX)/i', $statement)) {
                    try {
                        $db->execute($statement);
                    } catch (Exception $e) {
                        $logger->logError("Error executing schema statement: " . $statement, $e);
                        throw $e;
                    }
                }
            }
        }
    }
    
    // Second pass: Execute all other statements from schemas
    foreach ($sectionSchemas as $schemaFile) {
        $logger->logSqlFile($schemaFile, 'Loading section schema data');
        $schema = file_get_contents($schemaFile);
        
        // Split on semicolons but keep them in the statements
        $statements = preg_split('/(?<=[;])/', $schema, -1, PREG_SPLIT_NO_EMPTY);
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                // Execute non-CREATE statements
                if (!preg_match('/^\s*CREATE\s+(?:TABLE|INDEX)/i', $statement)) {
                    try {
                        $db->execute($statement);
                    } catch (Exception $e) {
                        $logger->logError("Error executing data statement: " . $statement, $e);
                        throw $e;
                    }
                }
            }
        }
    }

    // Load data from www/{domain}/sections/{section}/data.sql structure
    $logger->log("Loading website data...");
    $wwwPath = __DIR__ . '/www';
    
    // Get all domains
    $domains = glob($wwwPath . '/*', GLOB_ONLYDIR);
    
    foreach ($domains as $domainPath) {
        $domain = basename($domainPath);
        $logger->log("Processing domain: $domain");
        
        // Get all section data files
        $sectionDataFiles = glob($domainPath . '/sections/*/data.sql');
        
        foreach ($sectionDataFiles as $dataFile) {
            $section = basename(dirname($dataFile));
            $logger->logSqlFile($dataFile, "Loading data for domain '$domain' section '$section'");
            
            $data = file_get_contents($dataFile);
            
            // Split on semicolons but keep them in the statements
            $statements = preg_split('/(?<=[;])/', $data, -1, PREG_SPLIT_NO_EMPTY);
            
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    try {
                        $db->execute($statement);
                    } catch (Exception $e) {
                        $logger->logError("Error executing website data statement: " . $statement, $e);
                        throw $e;
                    }
                }
            }
        }
    }
    
    $logger->log("Database installation completed successfully");
    echo "Database installation completed successfully at: " . $dbPath . "\n";
    
} catch (Exception $e) {
    $logger->logError("Installation failed", $e);
    echo "Installation failed: " . $e->getMessage() . "\n";
}
