<?php
require_once __DIR__ . '/../../config/Database.php';

class MenuQuery {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getMenuData() {
        $data = [
            'config' => $this->getConfig(),
            'items' => $this->getMenuItems(),
            'categories' => $this->getMenuCategories()
        ];
        return $data;
    }

    private function getConfig() {
        $config = [];
        $result = $this->db->getConnection()->query(
            "SELECT name, value FROM config WHERE name LIKE 'menu_%'"
        );
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $key = str_replace('menu_', '', $row['name']);
            $config[$key] = $row['value'];
        }
        
        return $config;
    }

    private function getMenuItems($parentId = null) {
        $items = [];
        $query = "SELECT * FROM menu_items WHERE parent_id " . 
                 ($parentId === null ? "IS NULL" : "= " . $parentId) . 
                 " AND is_active = 1 ORDER BY position ASC";
        
        $result = $this->db->getConnection()->query($query);
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $item = $row;
            $children = $this->getMenuItems($row['id']);
            if (!empty($children)) {
                $item['children'] = $children;
            }
            $items[] = $item;
        }
        
        return $items;
    }

    private function getMenuCategories($parentId = null) {
        $categories = [];
        $query = "SELECT * FROM menu_categories 
                 WHERE parent_id " . ($parentId === null ? "IS NULL" : "= " . $parentId) . 
                 " AND is_active = 1 
                 AND show_in_menu = 1 
                 ORDER BY menu_position ASC";
        
        $result = $this->db->getConnection()->query($query);
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $category = $row;
            $children = $this->getMenuCategories($row['id']);
            if (!empty($children)) {
                $category['children'] = $children;
            }
            $categories[] = $category;
        }
        
        return $categories;
    }

    public function updateMenuItem($id, $data) {
        $stmt = $this->db->getConnection()->prepare(
            "UPDATE menu_items 
             SET title = :title, 
                 url = :url, 
                 parent_id = :parent_id, 
                 position = :position, 
                 is_active = :is_active,
                 target = :target,
                 icon_class = :icon_class,
                 updated_at = CURRENT_TIMESTAMP
             WHERE id = :id"
        );
        
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $stmt->bindValue(':title', $data['title'], SQLITE3_TEXT);
        $stmt->bindValue(':url', $data['url'], SQLITE3_TEXT);
        $stmt->bindValue(':parent_id', $data['parent_id'], $data['parent_id'] === null ? SQLITE3_NULL : SQLITE3_INTEGER);
        $stmt->bindValue(':position', $data['position'], SQLITE3_INTEGER);
        $stmt->bindValue(':is_active', $data['is_active'], SQLITE3_INTEGER);
        $stmt->bindValue(':target', $data['target'], SQLITE3_TEXT);
        $stmt->bindValue(':icon_class', $data['icon_class'], SQLITE3_TEXT);
        
        return $stmt->execute();
    }

    public function addMenuItem($data) {
        $stmt = $this->db->getConnection()->prepare(
            "INSERT INTO menu_items 
             (title, url, parent_id, position, is_active, target, icon_class) 
             VALUES (:title, :url, :parent_id, :position, :is_active, :target, :icon_class)"
        );
        
        $stmt->bindValue(':title', $data['title'], SQLITE3_TEXT);
        $stmt->bindValue(':url', $data['url'], SQLITE3_TEXT);
        $stmt->bindValue(':parent_id', $data['parent_id'], $data['parent_id'] === null ? SQLITE3_NULL : SQLITE3_INTEGER);
        $stmt->bindValue(':position', $data['position'], SQLITE3_INTEGER);
        $stmt->bindValue(':is_active', $data['is_active'], SQLITE3_INTEGER);
        $stmt->bindValue(':target', $data['target'], SQLITE3_TEXT);
        $stmt->bindValue(':icon_class', $data['icon_class'], SQLITE3_TEXT);
        
        return $stmt->execute();
    }

    public function deleteMenuItem($id) {
        // First update any children to have no parent
        $updateStmt = $this->db->getConnection()->prepare(
            "UPDATE menu_items SET parent_id = NULL WHERE parent_id = :id"
        );
        $updateStmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $updateStmt->execute();

        // Then delete the item
        $deleteStmt = $this->db->getConnection()->prepare(
            "DELETE FROM menu_items WHERE id = :id"
        );
        $deleteStmt->bindValue(':id', $id, SQLITE3_INTEGER);
        return $deleteStmt->execute();
    }

    public function updateCategory($id, $data) {
        $stmt = $this->db->getConnection()->prepare(
            "UPDATE menu_categories 
             SET name = :name,
                 slug = :slug,
                 description = :description,
                 parent_id = :parent_id,
                 sort_order = :sort_order,
                 is_active = :is_active,
                 show_in_menu = :show_in_menu,
                 menu_position = :menu_position,
                 updated_at = CURRENT_TIMESTAMP
             WHERE id = :id"
        );
        
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $stmt->bindValue(':name', $data['name'], SQLITE3_TEXT);
        $stmt->bindValue(':slug', $data['slug'], SQLITE3_TEXT);
        $stmt->bindValue(':description', $data['description'], SQLITE3_TEXT);
        $stmt->bindValue(':parent_id', $data['parent_id'], $data['parent_id'] === null ? SQLITE3_NULL : SQLITE3_INTEGER);
        $stmt->bindValue(':sort_order', $data['sort_order'], SQLITE3_INTEGER);
        $stmt->bindValue(':is_active', $data['is_active'], SQLITE3_INTEGER);
        $stmt->bindValue(':show_in_menu', $data['show_in_menu'], SQLITE3_INTEGER);
        $stmt->bindValue(':menu_position', $data['menu_position'], SQLITE3_INTEGER);
        
        return $stmt->execute();
    }

    public function addCategory($data) {
        $stmt = $this->db->getConnection()->prepare(
            "INSERT INTO menu_categories 
             (name, slug, description, parent_id, sort_order, is_active, show_in_menu, menu_position) 
             VALUES (:name, :slug, :description, :parent_id, :sort_order, :is_active, :show_in_menu, :menu_position)"
        );
        
        $stmt->bindValue(':name', $data['name'], SQLITE3_TEXT);
        $stmt->bindValue(':slug', $data['slug'], SQLITE3_TEXT);
        $stmt->bindValue(':description', $data['description'], SQLITE3_TEXT);
        $stmt->bindValue(':parent_id', $data['parent_id'], $data['parent_id'] === null ? SQLITE3_NULL : SQLITE3_INTEGER);
        $stmt->bindValue(':sort_order', $data['sort_order'], SQLITE3_INTEGER);
        $stmt->bindValue(':is_active', $data['is_active'], SQLITE3_INTEGER);
        $stmt->bindValue(':show_in_menu', $data['show_in_menu'], SQLITE3_INTEGER);
        $stmt->bindValue(':menu_position', $data['menu_position'], SQLITE3_INTEGER);
        
        return $stmt->execute();
    }

    public function deleteCategory($id) {
        // First update any children to have no parent
        $updateStmt = $this->db->getConnection()->prepare(
            "UPDATE menu_categories SET parent_id = NULL WHERE parent_id = :id"
        );
        $updateStmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $updateStmt->execute();

        // Then delete the category
        $deleteStmt = $this->db->getConnection()->prepare(
            "DELETE FROM menu_categories WHERE id = :id"
        );
        $deleteStmt->bindValue(':id', $id, SQLITE3_INTEGER);
        return $deleteStmt->execute();
    }

    public function updateConfig($data) {
        foreach ($data as $key => $value) {
            $name = 'menu_' . $key;
            $stmt = $this->db->getConnection()->prepare(
                "INSERT OR REPLACE INTO config (name, value, type, description) 
                 VALUES (:name, :value, 'text', 'Menu configuration')"
            );
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $stmt->bindValue(':value', $value, SQLITE3_TEXT);
            $stmt->execute();
        }
        return true;
    }
}
