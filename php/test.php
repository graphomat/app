<?php
class Diagnostics {
    private $errors = [];
    private $testType = null;
    private $tables = [];
    private $columns = [];

    public function __construct($testType = null) {
        $this->testType = $testType;
    }

    public function runTests() {
        if ($this->testType) {
            // Run specific tests based on parameter
            switch ($this->testType) {
                case 'components':
                    $this->testComponents();
                    break;
                case 'sections':
                    $this->testSections();
                    break;
                case 'schema':
                    $this->testSchemaForDuplicates();
                    break;
                default:
                    throw new Exception("Unknown test type: " . $this->testType);
            }
        } else {
            // Run all tests
            $this->testComponents();
            $this->testSections();
            $this->testSchemaForDuplicates();
        }

        return $this->errors;
    }

    private function testComponents() {
        $componentDirs = glob(__DIR__ . '/components/*', GLOB_ONLYDIR);
        
        foreach ($componentDirs as $dir) {
            $componentName = basename($dir);
            
            // Check required files
            $requiredFiles = ['html.php', 'style.css', 'script.js', 'admin.php'];
            foreach ($requiredFiles as $file) {
                if (!file_exists($dir . '/' . $file)) {
                    $this->errors[] = [
                        'type' => 'component',
                        'name' => $componentName,
                        'error' => "Missing required file: $file"
                    ];
                }
            }

            // Test PHP syntax
            $phpFiles = glob($dir . '/*.php');
            foreach ($phpFiles as $file) {
                exec("php -l " . escapeshellarg($file) . " 2>&1", $output, $return);
                if ($return !== 0) {
                    $this->errors[] = [
                        'type' => 'component',
                        'name' => $componentName,
                        'error' => "PHP syntax error in " . basename($file) . ": " . implode("\n", $output)
                    ];
                }
            }

            // Test JS syntax
            if (file_exists($dir . '/script.js')) {
                $jsContent = file_get_contents($dir . '/script.js');
                if (!$this->isValidJS($jsContent)) {
                    $this->errors[] = [
                        'type' => 'component',
                        'name' => $componentName,
                        'error' => "JavaScript syntax error in script.js"
                    ];
                }
            }
        }
    }

    private function testSections() {
        $sectionDirs = glob(__DIR__ . '/sections/*', GLOB_ONLYDIR);
        
        foreach ($sectionDirs as $dir) {
            $sectionName = basename($dir);
            
            // Skip special sections
            if (in_array($sectionName, ['index.php'])) {
                continue;
            }

            // Check required files
            $requiredFiles = ['html.php', 'query.php', 'admin.php'];
            foreach ($requiredFiles as $file) {
                if (!file_exists($dir . '/' . $file)) {
                    $this->errors[] = [
                        'type' => 'section',
                        'name' => $sectionName,
                        'error' => "Missing required file: $file"
                    ];
                }
            }

            // Test PHP syntax
            $phpFiles = glob($dir . '/*.php');
            foreach ($phpFiles as $file) {
                exec("php -l " . escapeshellarg($file) . " 2>&1", $output, $return);
                if ($return !== 0) {
                    $this->errors[] = [
                        'type' => 'section',
                        'name' => $sectionName,
                        'error' => "PHP syntax error in " . basename($file) . ": " . implode("\n", $output)
                    ];
                }
            }

            // Test SQL schema if exists
            if (file_exists($dir . '/schema.sql')) {
                $sqlContent = file_get_contents($dir . '/schema.sql');
                if (!$this->isValidSQL($sqlContent)) {
                    $this->errors[] = [
                        'type' => 'section',
                        'name' => $sectionName,
                        'error' => "SQL syntax error in schema.sql"
                    ];
                }
            }
        }
    }

    private function testSchemaForDuplicates() {
        // First, parse main schema.sql
        $mainSchemaPath = __DIR__ . '/schema.sql';
        if (file_exists($mainSchemaPath)) {
            $this->parseSchemaFile($mainSchemaPath, 'main');
        }

        // Then parse all component and section schema files
        $componentSchemas = glob(__DIR__ . '/components/*/schema.sql');
        foreach ($componentSchemas as $schema) {
            $componentName = basename(dirname($schema));
            $this->parseSchemaFile($schema, "component:$componentName");
        }

        $sectionSchemas = glob(__DIR__ . '/sections/*/schema.sql');
        foreach ($sectionSchemas as $schema) {
            $sectionName = basename(dirname($schema));
            $this->parseSchemaFile($schema, "section:$sectionName");
        }

        // Check for duplicates
        $this->checkForDuplicates();
    }

    private function parseSchemaFile($file, $source) {
        $content = file_get_contents($file);
        $lines = explode("\n", $content);
        $currentTable = null;

        foreach ($lines as $line) {
            $line = trim($line);
            
            // Skip comments and empty lines
            if (empty($line) || strpos($line, '--') === 0) {
                continue;
            }

            // Check for CREATE TABLE
            if (preg_match('/CREATE\s+TABLE\s+(\w+)\s*\(/i', $line, $matches)) {
                $currentTable = $matches[1];
                if (!isset($this->tables[$currentTable])) {
                    $this->tables[$currentTable] = [];
                }
                $this->tables[$currentTable][] = $source;
            }

            // Check for column definitions
            if ($currentTable && preg_match('/^\s*(\w+)\s+\w+/i', $line, $matches)) {
                $column = $matches[1];
                if (!isset($this->columns[$currentTable])) {
                    $this->columns[$currentTable] = [];
                }
                if (!isset($this->columns[$currentTable][$column])) {
                    $this->columns[$currentTable][$column] = [];
                }
                $this->columns[$currentTable][$column][] = $source;
            }
        }
    }

    private function checkForDuplicates() {
        // Check for duplicate tables
        foreach ($this->tables as $table => $sources) {
            if (count($sources) > 1) {
                $this->errors[] = [
                    'type' => 'schema',
                    'name' => $table,
                    'error' => "Table '$table' is defined multiple times in: " . implode(", ", $sources)
                ];
            }
        }

        // Check for duplicate columns
        foreach ($this->columns as $table => $columns) {
            foreach ($columns as $column => $sources) {
                if (count($sources) > 1) {
                    $this->errors[] = [
                        'type' => 'schema',
                        'name' => "$table.$column",
                        'error' => "Column '$column' in table '$table' is defined multiple times in: " . implode(", ", $sources)
                    ];
                }
            }
        }
    }

    private function isValidJS($content) {
        // Basic JS validation - could be enhanced
        return strpos($content, '{') !== false && 
               strpos($content, '}') !== false && 
               substr_count($content, '{') === substr_count($content, '}');
    }

    private function isValidSQL($content) {
        // Basic SQL validation - could be enhanced
        return strpos(strtoupper($content), 'CREATE TABLE') !== false || 
               strpos(strtoupper($content), 'ALTER TABLE') !== false ||
               strpos(strtoupper($content), 'INSERT INTO') !== false;
    }

    public function saveErrorsToFile($file = 'diagnostic_errors.json') {
        file_put_contents($file, json_encode($this->errors, JSON_PRETTY_PRINT));
    }
}

// CLI usage
if (php_sapi_name() === 'cli') {
    $testType = isset($argv[1]) ? $argv[1] : null;
    $diagnostics = new Diagnostics($testType);
    $errors = $diagnostics->runTests();
    $diagnostics->saveErrorsToFile();
    
    if (count($errors) > 0) {
        echo "Found " . count($errors) . " errors:\n";
        foreach ($errors as $error) {
            echo "[{$error['type']}] {$error['name']}: {$error['error']}\n";
        }
        exit(1);
    } else {
        echo "No errors found.\n";
        exit(0);
    }
}
