<?php
require_once __DIR__ . '/../../config/Database.php';

function getTeamFullData() {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    $teamMembers = [];
    
    // Get all team members
    $query = "SELECT 
        id,
        name,
        position_key,
        bio_key,
        photo,
        credentials,
        specialties,
        education,
        publications
    FROM team_members 
    WHERE is_active = 1 
    ORDER BY display_order ASC";
    
    $result = $conn->query($query);
    
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        // Convert JSON strings to arrays for array fields
        $specialties = !empty($row['specialties']) ? json_decode($row['specialties'], true) : [];
        $education = !empty($row['education']) ? json_decode($row['education'], true) : [];
        $publications = !empty($row['publications']) ? json_decode($row['publications'], true) : [];
        
        $teamMembers[] = [
            'name' => $row['name'],
            'position_key' => $row['position_key'],
            'bio_key' => $row['bio_key'],
            'photo' => $row['photo'],
            'credentials' => $row['credentials'],
            'specialties' => $specialties,
            'education' => $education,
            'publications' => $publications
        ];
    }
    
    return ['team_members' => $teamMembers];
}
