<?php

function getExpertiseData() {
    try {
        $db = Database::getInstance();
        
        $query = "SELECT 
            e.id,
            e.title,
            e.description,
            e.icon_url as icon,
            GROUP_CONCAT(ep.point_text) as key_points
        FROM expertise e
        LEFT JOIN expertise_points ep ON e.id = ep.expertise_id
        WHERE e.active = 1
        GROUP BY e.id
        ORDER BY e.display_order";
        
        $result = $db->query($query);
        
        $expertise = [];
        foreach ($result as $row) {
            // Convert key_points string to array
            $row['key_points'] = $row['key_points'] 
                ? explode(',', $row['key_points']) 
                : [];
            $expertise[] = $row;
        }
        
        return $expertise;
        
    } catch (Exception $e) {
        error_log("Error fetching expertise data: " . $e->getMessage());
        return [];
    }
}
