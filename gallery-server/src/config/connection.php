<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "gallery_server";
$socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock";

// Establish Connectio
$conn = new mysqli($host, $user, $pass, $dbname, null, $socket);

// Check Connection
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}
