<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../helpers/response.php';
require_once __DIR__ . '/../helpers/base64_helper.php';

// Set CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Ensure request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    ResponseHelper::jsonResponse(["error" => "Invalid request method"], 405);
}

// Authenticate User
if (!isset($_SERVER["HTTP_AUTHORIZATION"])) {
    ResponseHelper::jsonResponse(["error" => "Unauthorized - Missing Token"], 401);
}

$base64Token = str_replace("Bearer ", "", $_SERVER["HTTP_AUTHORIZATION"]);
$userData = AuthHelper::decodeToken($base64Token);

if (!$userData) {
    ResponseHelper::jsonResponse(["error" => "Unauthorized - Invalid Token"], 401);
}

// Parse JSON request body
$data = json_decode(file_get_contents("php://input"), true) ?? [];

if (!isset($data["user_id"], $data["image_base64"])) {
    ResponseHelper::jsonResponse(["error" => "User ID and image are required"], 400);
}

$user_id = intval($data["user_id"]);
$decodeResult = Base64Helper::decodeBase64Image($data["image_base64"]);

if (isset($decodeResult["error"])) {
    ResponseHelper::jsonResponse(["error" => $decodeResult["error"]], 400);
}

$imageData = $decodeResult["data"];
$imageType = $decodeResult["extension"];

// Ensure `/uploads/` directory exists
$uploadDir = __DIR__ . "/../uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Generate unique filename & save image
$filename = uniqid("img_", true) . ".$imageType";
$targetPath = $uploadDir . $filename;

if (file_put_contents($targetPath, $imageData) === false) {
    ResponseHelper::jsonResponse(["error" => "Failed to save image"], 500);
}

// Store metadata in database
$title = $data["title"] ?? "Untitled";
$description = $data["description"] ?? "";
$tags = $data["tags"] ?? "";
$imageURL = "http://localhost/PhotoGallery/gallery-server/uploads/" . $filename;

global $conn;
$stmt = $conn->prepare("INSERT INTO photos (user_id, title, description, tags, image_path) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $user_id, $title, $description, $tags, $filename);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    ResponseHelper::jsonResponse(["success" => "Image uploaded successfully", "image_url" => $imageURL]);
} else {
    ResponseHelper::jsonResponse(["error" => "Failed to save metadata"], 500);
}

$stmt->close();
