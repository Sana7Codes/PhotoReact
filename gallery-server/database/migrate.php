<?php
require_once __DIR__ . '/../src/config/connection.php';

// Use the existing $conn from connection.php
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Create Users Table
$userTable = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

if ($conn->query($userTable) === TRUE) {
    echo " Users table created successfully.<br>";
} else {
    echo " Error creating users table: " . $conn->error . "<br>";
}

// Create Photos Table
$photosTable = "CREATE TABLE IF NOT EXISTS photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    tags TEXT,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);";

if ($conn->query($photosTable) === TRUE) {
    echo " Photos table created successfully.<br>";
} else {
    echo " Error creating photos table: " . $conn->error . "<br>";
}

// Close the connection
$conn->close();
