<?php

function getEducationData() {
    global $db;
    
    try {
        // Get main education settings
        $query = "SELECT 
            e.id,
            e.intro,
            e.cta_title,
            e.cta_description,
            e.cta_link,
            e.cta_button_text
        FROM education_settings e
        WHERE e.active = 1
        LIMIT 1";
        
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        $educationData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$educationData) {
            return null;
        }
        
        // Format CTA data
        if ($educationData['cta_title']) {
            $educationData['cta'] = [
                'title' => $educationData['cta_title'],
                'description' => $educationData['cta_description'],
                'link' => $educationData['cta_link'],
                'button_text' => $educationData['cta_button_text']
            ];
        }
        
        // Remove individual CTA fields
        unset($educationData['cta_title']);
        unset($educationData['cta_description']);
        unset($educationData['cta_link']);
        unset($educationData['cta_button_text']);
        
        // Get education programs
        $programsQuery = "SELECT 
            p.id,
            p.title,
            p.description,
            p.image_url as image,
            p.duration,
            p.start_date,
            p.link,
            GROUP_CONCAT(pd.detail_text) as details
        FROM education_programs p
        LEFT JOIN program_details pd ON p.id = pd.program_id
        WHERE p.active = 1
        GROUP BY p.id
        ORDER BY p.display_order";
        
        $stmt = $db->prepare($programsQuery);
        $stmt->execute();
        
        $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Process program details
        foreach ($programs as &$program) {
            $program['details'] = $program['details'] 
                ? explode(',', $program['details']) 
                : [];
                
            // Format date if exists
            if (isset($program['start_date'])) {
                $program['start_date'] = date('d.m.Y', strtotime($program['start_date']));
            }
        }
        
        $educationData['programs'] = $programs;
        
        return $educationData;
        
    } catch (PDOException $e) {
        error_log("Error fetching education data: " . $e->getMessage());
        return null;
    }
}
