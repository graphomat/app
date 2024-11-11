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
    echo "Using database path: $dbPath\n";
    $logger->log("Using database path: $dbPath");

    // Ensure database directory exists
    $dbDir = dirname($dbPath);
    if (!is_dir($dbDir)) {
        echo "Creating database directory: $dbDir\n";
        $logger->log("Creating database directory: $dbDir");
        mkdir($dbDir, 0777, true);
    }
    
    // Get database instance with explicit path
    $db = Database::getInstance($dbPath);
    
    // Drop existing tables in reverse order to handle foreign key constraints
    echo "Dropping existing tables...\n";
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
    echo "Loading main schema from: $schemaFile\n";
    $logger->logSqlFile($schemaFile, 'Loading main schema');
    $schema = file_get_contents($schemaFile);
    $statements = explode(';', $schema);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            echo "Executing schema statement\n";
            $db->execute($statement);
        }
    }

    // Load site data
    $siteFile = __DIR__ . '/www/localhost/site.sql';
    if (file_exists($siteFile)) {
        echo "Loading site data from: $siteFile\n";
        $siteData = file_get_contents($siteFile);
        $db->execute($siteData);
        
        // Verify site was created
        $sites = $db->query("SELECT * FROM sites");
        echo "Sites in database: " . count($sites) . "\n";
        foreach ($sites as $site) {
            echo "Site: {$site['name']} ({$site['domain']})\n";
        }
    }

    // Load page data
    $pageFiles = glob(__DIR__ . '/www/localhost/pages/*.sql');
    foreach ($pageFiles as $pageFile) {
        echo "Loading page data from: " . basename($pageFile) . "\n";
        $pageData = file_get_contents($pageFile);
        $db->execute($pageData);
    }

    // Verify pages were created
    $pages = $db->query("SELECT p.*, s.domain FROM pages p JOIN sites s ON p.site_id = s.id");
    echo "Pages in database: " . count($pages) . "\n";
    foreach ($pages as $page) {
        echo "Page: {$page['title']} (/{$page['slug']}) - {$page['status']}\n";
    }

    // Load and execute all section schemas
    echo "Loading section schemas...\n";
    $logger->log("Loading section schemas...");
    $sectionSchemas = glob(__DIR__ . '/sections/*/schema.sql');
    
    // First pass: Create all tables
    foreach ($sectionSchemas as $schemaFile) {
        echo "Creating tables from section schema: " . basename(dirname($schemaFile)) . "\n";
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
                        echo "Error executing schema statement: " . $statement . "\n";
                        $logger->logError("Error executing schema statement: " . $statement, $e);
                        throw $e;
                    }
                }
            }
        }
    }
    
    // Second pass: Execute all other statements from schemas
    foreach ($sectionSchemas as $schemaFile) {
        echo "Loading section schema data: " . basename(dirname($schemaFile)) . "\n";
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
                        echo "Error executing data statement: " . $statement . "\n";
                        $logger->logError("Error executing data statement: " . $statement, $e);
                        throw $e;
                    }
                }
            }
        }
    }

    // Load data from www/{domain}/sections/{section}/data.sql structure
    echo "Loading website data...\n";
    $logger->log("Loading website data...");
    $wwwPath = __DIR__ . '/www';
    
    // Get all domains
    $domains = glob($wwwPath . '/*', GLOB_ONLYDIR);
    
    foreach ($domains as $domainPath) {
        $domain = basename($domainPath);
        echo "Processing domain: $domain\n";
        $logger->log("Processing domain: $domain");
        
        // Get all section data files
        $sectionDataFiles = glob($domainPath . '/sections/*/data.sql');
        
        foreach ($sectionDataFiles as $dataFile) {
            $section = basename(dirname($dataFile));
            echo "Loading data for domain '$domain' section '$section'\n";
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
                        echo "Error executing website data statement: " . $statement . "\n";
                        $logger->logError("Error executing website data statement: " . $statement, $e);
                        throw $e;
                    }
                }
            }
        }
    }
    
    echo "Database installation completed successfully at: " . $dbPath . "\n";
    $logger->log("Database installation completed successfully");
    
} catch (Exception $e) {
    echo "Installation failed: " . $e->getMessage() . "\n";
    $logger->logError("Installation failed", $e);
}
