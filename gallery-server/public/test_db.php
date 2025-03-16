<?php
$socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock";
$mysqli = new mysqli("localhost", "root", "", "gallery_server", null, $socket);


if ($mysqli->connect_error) {
    die("❌ Connection failed: " . $mysqli->connect_error);
}
echo "✅ MySQL Connection Successful!";
