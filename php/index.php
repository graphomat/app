<?php
require_once __DIR__ . '/config/env.php';
require_once __DIR__ . '/config/Logger.php';
require_once __DIR__ . '/config/Database.php';
putenv("APP_NAME=index");

class PageLoader {
    private $logger;
    private $db;
    private $loadedStyles = [];
    private $loadedScripts = [];

    public function __construct() {
        $this->logger = Logger::getInstance();
        $this->logger->log("Request started: " . $_SERVER['REQUEST_URI']);
        
        // Initialize database
        if (!getenv('DB_PATH')) {
            throw new Exception('DB_PATH environment variable is not set');
        }
        $this->db = Database::getInstance();
    }

    public function loadSection($sectionName) {
        $sectionPath = __DIR__ . '/sections/' . $sectionName;
        
        // Check if section exists
        if (!is_dir($sectionPath)) {
            $this->logger->log("Section not found: {$sectionName}", "ERROR");
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

    public function run() {
        try {
            // Get current page from URL
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $page = trim($uri, '/');
            if (empty($page)) {
                $page = 'home';
            }
            
            $this->logger->log("Loading page: $page");
            
            // Get page data
            $pageData = $this->db->query(
                "SELECT * FROM pages WHERE slug = :slug AND status = 'published'",
                ['slug' => $page]
            );
            
            if (empty($pageData)) {
                $this->logger->log("Page not found: $page", "ERROR");
                header("HTTP/1.0 404 Not Found");
                include __DIR__ . '/404.php';
                exit;
            }
            
            $pageId = $pageData[0]['id'];
            $this->logger->log("Page found, ID: $pageId");
            
            // Get page meta data
            $metaData = $this->db->query(
                "SELECT * FROM meta WHERE page_id = :page_id",
                ['page_id' => $pageId]
            );
            $this->logger->log("Meta data loaded");
            
            // Get page sections
            $sections = $this->db->query(
                "SELECT * FROM sections WHERE page_id = :page_id ORDER BY sort_order ASC",
                ['page_id' => $pageId]
            );
            $this->logger->log("Loaded " . count($sections) . " sections");
            
            // Start output buffering
            ob_start();
            
            // Include header
            include __DIR__ . '/header.php';
            
            // Render each section
            foreach ($sections as $section) {
                try {
                    $this->logger->log("Rendering section: " . $section['name']);
                    $this->loadSection($section['name']);
                } catch (Exception $e) {
                    $this->logger->logError("Error rendering section: " . $section['name'], $e);
                }
            }
            
            // Include footer
            include __DIR__ . '/footer.php';
            
            // Send output
            ob_end_flush();
            
            $this->logger->log("Page rendered successfully");
            
        } catch (Exception $e) {
            $this->logger->logError("Fatal error", $e);
            
            // Clear any output
            if (ob_get_level() > 0) {
                ob_end_clean();
            }
            
            // Show error page
            header("HTTP/1.0 500 Internal Server Error");
            include __DIR__ . '/500.php';
        }
    }
}

// Initialize and run the page loader
$pageLoader = new PageLoader();
$pageLoader->run();
