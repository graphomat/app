<?php
class MetaQuery {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getMetaByPageId($pageId) {
        $stmt = $this->db->prepare("SELECT * FROM meta WHERE page_id = ?");
        $stmt->bind_param("s", $pageId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateMeta($data) {
        $stmt = $this->db->prepare("
            INSERT INTO meta (
                page_id, title, description, keywords, author, robots,
                og_title, og_description, og_image, og_type,
                twitter_card, twitter_site, twitter_creator, twitter_title, twitter_description, twitter_image,
                canonical_url
            ) VALUES (
                ?, ?, ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?,
                ?
            ) ON DUPLICATE KEY UPDATE
                title = VALUES(title),
                description = VALUES(description),
                keywords = VALUES(keywords),
                author = VALUES(author),
                robots = VALUES(robots),
                og_title = VALUES(og_title),
                og_description = VALUES(og_description),
                og_image = VALUES(og_image),
                og_type = VALUES(og_type),
                twitter_card = VALUES(twitter_card),
                twitter_site = VALUES(twitter_site),
                twitter_creator = VALUES(twitter_creator),
                twitter_title = VALUES(twitter_title),
                twitter_description = VALUES(twitter_description),
                twitter_image = VALUES(twitter_image),
                canonical_url = VALUES(canonical_url)
        ");

        $stmt->bind_param(
            "sssssssssssssssss",
            $data['page_id'],
            $data['title'],
            $data['description'],
            $data['keywords'],
            $data['author'],
            $data['robots'],
            $data['og_title'],
            $data['og_description'],
            $data['og_image'],
            $data['og_type'],
            $data['twitter_card'],
            $data['twitter_site'],
            $data['twitter_creator'],
            $data['twitter_title'],
            $data['twitter_description'],
            $data['twitter_image'],
            $data['canonical_url']
        );

        return $stmt->execute();
    }

    public function deleteMeta($pageId) {
        $stmt = $this->db->prepare("DELETE FROM meta WHERE page_id = ?");
        $stmt->bind_param("s", $pageId);
        return $stmt->execute();
    }
}
