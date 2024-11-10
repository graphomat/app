<?php
require_once __DIR__ . '/../../config/Database.php';

class FooterQuery {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getFooterData() {
        $data = [
            'config' => $this->getConfig(),
            'links' => $this->getLinks(),
            'social' => $this->getSocialLinks()
        ];
        return $data;
    }

    private function getConfig() {
        $config = [];
        $result = $this->db->getConnection()->query(
            "SELECT name, value FROM config WHERE name LIKE 'footer_%'"
        );
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $key = str_replace('footer_', '', $row['name']);
            $config[$key] = $row['value'];
        }
        
        return $config;
    }

    private function getLinks() {
        $links = [];
        $result = $this->db->getConnection()->query(
            "SELECT * FROM footer_links WHERE is_active = 1 ORDER BY column_number, sort_order ASC"
        );
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $columnNum = $row['column_number'];
            if (!isset($links[$columnNum])) {
                $links[$columnNum] = [];
            }
            $links[$columnNum][] = $row;
        }
        
        return $links;
    }

    private function getSocialLinks() {
        $social = [];
        $result = $this->db->getConnection()->query(
            "SELECT * FROM footer_social WHERE is_active = 1 ORDER BY sort_order ASC"
        );
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $social[] = $row;
        }
        
        return $social;
    }

    public function updateLink($id, $data) {
        $stmt = $this->db->getConnection()->prepare(
            "UPDATE footer_links 
             SET title = :title, 
                 url = :url, 
                 column_number = :column_number, 
                 sort_order = :sort_order, 
                 is_active = :is_active,
                 updated_at = CURRENT_TIMESTAMP
             WHERE id = :id"
        );
        
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $stmt->bindValue(':title', $data['title'], SQLITE3_TEXT);
        $stmt->bindValue(':url', $data['url'], SQLITE3_TEXT);
        $stmt->bindValue(':column_number', $data['column_number'], SQLITE3_INTEGER);
        $stmt->bindValue(':sort_order', $data['sort_order'], SQLITE3_INTEGER);
        $stmt->bindValue(':is_active', $data['is_active'], SQLITE3_INTEGER);
        
        return $stmt->execute();
    }

    public function addLink($data) {
        $stmt = $this->db->getConnection()->prepare(
            "INSERT INTO footer_links 
             (title, url, column_number, sort_order, is_active) 
             VALUES (:title, :url, :column_number, :sort_order, :is_active)"
        );
        
        $stmt->bindValue(':title', $data['title'], SQLITE3_TEXT);
        $stmt->bindValue(':url', $data['url'], SQLITE3_TEXT);
        $stmt->bindValue(':column_number', $data['column_number'], SQLITE3_INTEGER);
        $stmt->bindValue(':sort_order', $data['sort_order'], SQLITE3_INTEGER);
        $stmt->bindValue(':is_active', $data['is_active'], SQLITE3_INTEGER);
        
        return $stmt->execute();
    }

    public function deleteLink($id) {
        $stmt = $this->db->getConnection()->prepare(
            "DELETE FROM footer_links WHERE id = :id"
        );
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        return $stmt->execute();
    }

    public function updateSocialLink($id, $data) {
        $stmt = $this->db->getConnection()->prepare(
            "UPDATE footer_social 
             SET platform = :platform, 
                 url = :url, 
                 icon_svg = :icon_svg, 
                 sort_order = :sort_order, 
                 is_active = :is_active,
                 updated_at = CURRENT_TIMESTAMP
             WHERE id = :id"
        );
        
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $stmt->bindValue(':platform', $data['platform'], SQLITE3_TEXT);
        $stmt->bindValue(':url', $data['url'], SQLITE3_TEXT);
        $stmt->bindValue(':icon_svg', $data['icon_svg'], SQLITE3_TEXT);
        $stmt->bindValue(':sort_order', $data['sort_order'], SQLITE3_INTEGER);
        $stmt->bindValue(':is_active', $data['is_active'], SQLITE3_INTEGER);
        
        return $stmt->execute();
    }

    public function addSocialLink($data) {
        $stmt = $this->db->getConnection()->prepare(
            "INSERT INTO footer_social 
             (platform, url, icon_svg, sort_order, is_active) 
             VALUES (:platform, :url, :icon_svg, :sort_order, :is_active)"
        );
        
        $stmt->bindValue(':platform', $data['platform'], SQLITE3_TEXT);
        $stmt->bindValue(':url', $data['url'], SQLITE3_TEXT);
        $stmt->bindValue(':icon_svg', $data['icon_svg'], SQLITE3_TEXT);
        $stmt->bindValue(':sort_order', $data['sort_order'], SQLITE3_INTEGER);
        $stmt->bindValue(':is_active', $data['is_active'], SQLITE3_INTEGER);
        
        return $stmt->execute();
    }

    public function deleteSocialLink($id) {
        $stmt = $this->db->getConnection()->prepare(
            "DELETE FROM footer_social WHERE id = :id"
        );
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        return $stmt->execute();
    }

    public function updateConfig($data) {
        foreach ($data as $key => $value) {
            $name = 'footer_' . $key;
            $stmt = $this->db->getConnection()->prepare(
                "INSERT OR REPLACE INTO config (name, value, type, description) 
                 VALUES (:name, :value, 'text', 'Footer configuration')"
            );
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $stmt->bindValue(':value', $value, SQLITE3_TEXT);
            $stmt->execute();
        }
        return true;
    }
}
