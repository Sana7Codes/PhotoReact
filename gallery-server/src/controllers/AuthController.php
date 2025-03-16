<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/response.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // User Login
    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["email"], $data["password"])) {
            ResponseHelper::jsonResponse(["error" => "Email and password are required"], 400);
        }

        $user = $this->userModel->findByEmail($data["email"]);

        if (!$user || !AuthHelper::verifyPassword($data["password"], $user["password"])) {
            ResponseHelper::jsonResponse(["error" => "Invalid credentials"], 401);
        }

        // Generate Base64-encoded token
        $tokenPayload = json_encode([
            "id" => $user["id"],
            "username" => $user["username"],
            "email" => $user["email"]
        ]);

        $base64Token = base64_encode($tokenPayload);

        ResponseHelper::jsonResponse(["token" => $base64Token]);
    }
    public static function decodeToken($base64Token)
    {
        file_put_contents(__DIR__ . "/../logs/debug_token.txt", "Received Token: " . $base64Token);

        $decoded = base64_decode($base64Token);
        $userData = json_decode($decoded, true);

        if (!$userData) {
            file_put_contents(__DIR__ . "/../logs/debug_token.txt", "Token Decoding Failed: " . $base64Token, FILE_APPEND);
            return null;
        }

        return $userData;
    }


    // Decode Token and Get User Data
    public static function getUserFromToken()
    {
        if (!isset($_SERVER["HTTP_AUTHORIZATION"])) {
            ResponseHelper::jsonResponse(["error" => "Unauthorized - Missing Token"], 401);
        }

        $base64Token = str_replace("Bearer ", "", $_SERVER["HTTP_AUTHORIZATION"]);
        $userData = AuthHelper::decodeToken($base64Token);

        if (!$userData) {
            ResponseHelper::jsonResponse(["error" => "Unauthorized - Invalid Token"], 401);
        }

        return $userData; // Return decoded user data
    }
}
