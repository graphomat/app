<?php
require_once __DIR__ . '/../../config/Database.php';

class SEO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getGlobalSeo() {
        try {
            $query = "SELECT name, value FROM config WHERE name LIKE 'seo_%'";
            $result = $this->db->getConnection()->query($query);
            
            $seoData = [
                'default_title' => '',
                'default_description' => '',
                'default_keywords' => '',
                'og_image' => ''
            ];
            
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $key = str_replace('seo_', '', $row['name']);
                $seoData[$key] = $row['value'];
            }
            
            return $seoData;
        } catch (Exception $e) {
            error_log('Get global SEO error: ' . $e->getMessage());
            throw new Exception('Failed to get global SEO settings');
        }
    }

    public function updateGlobalSeo($data) {
        try {
            $allowedFields = [
                'default_title',
                'default_description',
                'default_keywords',
                'og_image'
            ];

            foreach ($allowedFields as $field) {
                if (isset($data[$field])) {
                    $name = 'seo_' . $field;
                    $value = $data[$field];
                    
                    // Check if config exists
                    $checkQuery = "SELECT id FROM config WHERE name = :name";
                    $checkStmt = $this->db->getConnection()->prepare($checkQuery);
                    $checkStmt->bindValue(':name', $name, SQLITE3_TEXT);
                    $result = $checkStmt->execute();
                    
                    if ($result->fetchArray()) {
                        // Update existing
                        $updateQuery = "UPDATE config SET value = :value WHERE name = :name";
                        $updateStmt = $this->db->getConnection()->prepare($updateQuery);
                        $updateStmt->bindValue(':name', $name, SQLITE3_TEXT);
                        $updateStmt->bindValue(':value', $value, SQLITE3_TEXT);
                        $updateStmt->execute();
                    } else {
                        // Insert new
                        $insertQuery = "INSERT INTO config (name, value, type, description) VALUES (:name, :value, 'text', 'SEO Setting')";
                        $insertStmt = $this->db->getConnection()->prepare($insertQuery);
                        $insertStmt->bindValue(':name', $name, SQLITE3_TEXT);
                        $insertStmt->bindValue(':value', $value, SQLITE3_TEXT);
                        $insertStmt->execute();
                    }
                }
            }
            
            return ['success' => true, 'message' => 'Global SEO settings updated successfully'];
        } catch (Exception $e) {
            error_log('Update global SEO error: ' . $e->getMessage());
            throw new Exception('Failed to update global SEO settings');
        }
    }

    public function getPagesSeo() {
        try {
            $query = "SELECT c.id, c.title, s.* FROM content c 
                     LEFT JOIN seo s ON c.id = s.page_id 
                     ORDER BY c.created_at DESC";
            $result = $this->db->getConnection()->query($query);
            
            $pages = [];
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $pages[] = $row;
            }
            
            return $pages;
        } catch (Exception $e) {
            error_log('Get pages SEO error: ' . $e->getMessage());
            throw new Exception('Failed to get pages SEO settings');
        }
    }

    public function getPageSeo($pageId) {
        try {
            $query = "SELECT * FROM seo WHERE page_id = :page_id";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->bindValue(':page_id', $pageId, SQLITE3_INTEGER);
            $result = $stmt->execute();
            
            return $result->fetchArray(SQLITE3_ASSOC) ?: [];
        } catch (Exception $e) {
            error_log('Get page SEO error: ' . $e->getMessage());
            throw new Exception('Failed to get page SEO settings');
        }
    }

    public function updatePageSeo($pageId, $data) {
        try {
            $allowedFields = [
                'meta_title',
                'meta_description',
                'meta_keywords',
                'og_title',
                'og_description',
                'og_image',
                'canonical_url'
            ];

            // Check if SEO entry exists
            $checkQuery = "SELECT id FROM seo WHERE page_id = :page_id";
            $checkStmt = $this->db->getConnection()->prepare($checkQuery);
            $checkStmt->bindValue(':page_id', $pageId, SQLITE3_INTEGER);
            $result = $checkStmt->execute();
            
            if ($result->fetchArray()) {
                // Update existing
                $updateFields = [];
                $params = [':page_id' => $pageId];
                
                foreach ($allowedFields as $field) {
                    if (isset($data[$field])) {
                        $updateFields[] = "$field = :$field";
                        $params[":$field"] = $data[$field];
                    }
                }
                
                if (!empty($updateFields)) {
                    $updateQuery = "UPDATE seo SET " . implode(', ', $updateFields) . " WHERE page_id = :page_id";
                    $updateStmt = $this->db->getConnection()->prepare($updateQuery);
                    foreach ($params as $key => $value) {
                        $updateStmt->bindValue($key, $value);
                    }
                    $updateStmt->execute();
                }
            } else {
                // Insert new
                $fields = ['page_id'];
                $values = [':page_id'];
                $params = [':page_id' => $pageId];
                
                foreach ($allowedFields as $field) {
                    if (isset($data[$field])) {
                        $fields[] = $field;
                        $values[] = ":$field";
                        $params[":$field"] = $data[$field];
                    }
                }
                
                $insertQuery = "INSERT INTO seo (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $values) . ")";
                $insertStmt = $this->db->getConnection()->prepare($insertQuery);
                foreach ($params as $key => $value) {
                    $insertStmt->bindValue($key, $value);
                }
                $insertStmt->execute();
            }
            
            return ['success' => true, 'message' => 'Page SEO settings updated successfully'];
        } catch (Exception $e) {
            error_log('Update page SEO error: ' . $e->getMessage());
            throw new Exception('Failed to update page SEO settings');
        }
    }
}
