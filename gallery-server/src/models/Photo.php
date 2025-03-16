<?php

require_once __DIR__ . '/PhotoSkeleton.php';
require_once __DIR__ . '/../config/connection.php';

class Photo extends PhotoSkeleton
{
    private $db;

    public function __construct()
    {
        global $conn;
        $this->db = $conn;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT id, user_id, title, description, tags, image_path, created_at FROM photos ORDER BY created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();

        $photos = [];
        while ($row = $result->fetch_assoc()) {
            $row["image_url"] = $this->getImageUrl($row["image_path"]);
            $photos[] = $row;
        }

        return $photos;
    }

    public function save($user_id, $title, $description, $tags, $filename)
    {
        $stmt = $this->db->prepare("INSERT INTO photos (user_id, title, description, tags, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $title, $description, $tags, $filename);
        return $stmt->execute();
    }

    // Function to generate image URL
    public function getImageUrl($imagePath)
    {
        return "http://localhost/PhotoGallery/gallery-server/uploads/" . $imagePath;
    }
}
