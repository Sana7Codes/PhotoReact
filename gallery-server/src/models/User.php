<?php
require_once __DIR__ . '/UserSkeleton.php';
require_once __DIR__ . '/../config/connection.php';

class User extends UserSkeleton
{
    private $db;

    public function __construct()
    {
        global $conn;
        $this->db = $conn;
    }

    public function create($username, $email, $password)
    {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        return $stmt->execute();
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
