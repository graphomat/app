<?php
require_once __DIR__ . '/config/Database.php';

class SectionLoader {
    private $db;
    private $loadedStyles = [];
    private $loadedScripts = [];

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getActiveSections() {
        $sections = [];
        $result = $this->db->getConnection()->query(
            "SELECT s.name, s.title 
             FROM sections s 
             LEFT JOIN pages p ON s.page_id = p.id 
             WHERE p.status = 'published' OR p.id IS NULL 
             ORDER BY s.sort_order ASC"
        );
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $sections[] = $row;
        }
        
        return $sections;
    }

    public function loadSection($sectionName) {
        $sectionPath = __DIR__ . '/sections/' . $sectionName;
        
        // Check if section exists
        if (!is_dir($sectionPath)) {
            error_log("Section not found: {$sectionName}");
            return false;
        }

        // Load section files
        $this->loadSectionStyle($sectionName);
        $this->loadSectionHTML($sectionName);
        $this->registerSectionScript($sectionName);
        
        return true;
    }

    private function loadSectionStyle($sectionName) {
        $stylePath = "/sections/{$sectionName}/style.css";
        if (!in_array($stylePath, $this->loadedStyles) && file_exists(__DIR__ . $stylePath)) {
            $this->loadedStyles[] = $stylePath;
            echo "<link rel='stylesheet' href='{$stylePath}?v=" . filemtime(__DIR__ . $stylePath) . "'>\n";
        }
    }

    private function loadSectionHTML($sectionName) {
        $htmlPath = __DIR__ . "/sections/{$sectionName}/html.php";
        if (file_exists($htmlPath)) {
            include $htmlPath;
        }
    }

    private function registerSectionScript($sectionName) {
        $scriptPath = "/sections/{$sectionName}/script.js";
        if (!in_array($scriptPath, $this->loadedScripts) && file_exists(__DIR__ . $scriptPath)) {
            $this->loadedScripts[] = $scriptPath;
            echo "<script defer src='{$scriptPath}?v=" . filemtime(__DIR__ . $scriptPath) . "'></script>\n";
        }
    }
}

// Initialize section loader
$sectionLoader = new SectionLoader();
$activeSections = $sectionLoader->getActiveSections();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DBT Unity - Диалектическая поведенческая терапия</title>
    
    <!-- Base styles -->
    <link rel="stylesheet" href="/styles.css">
    
    <!-- Sections styles will be loaded here -->
</head>
<body>
    <?php
    // Load each active section
    foreach ($activeSections as $section) {
        $sectionLoader->loadSection($section['name']);
    }
    ?>
    
    <!-- Base scripts -->
    <script src="/js/main.js" defer></script>
</body>
</html>
