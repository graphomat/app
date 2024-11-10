<?php
class Diagnostics {
    private $errors = [];
    private $testType = null;

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
                default:
                    throw new Exception("Unknown test type: " . $this->testType);
            }
        } else {
            // Run all tests
            $this->testComponents();
            $this->testSections();
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

    private function isValidJS($content) {
        // Basic JS validation - could be enhanced
        return strpos($content, '{') !== false && 
               strpos($content, '}') !== false && 
               substr_count($content, '{') === substr_count($content, '}');
    }

    private function isValidSQL($content) {
        // Basic SQL validation - could be enhanced
        return strpos(strtoupper($content), 'CREATE TABLE') !== false || 
               strpos(strtoupper($content), 'ALTER TABLE') !== false;
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
