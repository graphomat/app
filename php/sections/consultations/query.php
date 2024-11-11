<?php

class ConsultationsQuery {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function getConsultationsData() {
        $data = [
            'types' => $this->getConsultationTypes(),
            'note' => $this->getNote()
        ];

        return $data;
    }

    private function getConsultationTypes() {
        $query = "SELECT * FROM consultation_types WHERE is_active = 1 ORDER BY sort_order ASC";
        $result = $this->db->query($query);
        $types = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // Parse JSON fields
            $row['features'] = json_decode($row['features'] ?? '[]', true);
            $types[] = $row;
        }

        return $types;
    }

    private function getNote() {
        $query = "SELECT value FROM config WHERE name = 'consultations_note'";
        $result = $this->db->query($query);
        $row = $result->fetchArray(SQLITE3_ASSOC);
        
        return $row['value'] ?? '';
    }
}
