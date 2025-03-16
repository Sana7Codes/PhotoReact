<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/response.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["username"], $data["email"], $data["password"])) {
            ResponseHelper::jsonResponse(["error" => "Missing required fields"], 400);
        }

        $hashedPassword = AuthHelper::hashPassword($data["password"]);
        $success = $this->userModel->create($data["username"], $data["email"], $hashedPassword);

        if ($success) {
            ResponseHelper::jsonResponse(["success" => "User registered successfully"]);
        } else {
            ResponseHelper::jsonResponse(["error" => "Failed to register user"], 500);
        }
    }

    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["email"], $data["password"])) {
            ResponseHelper::jsonResponse(["error" => "Missing email or password"], 400);
        }

        $user = $this->userModel->findByEmail($data["email"]);
        if (!$user || !AuthHelper::verifyPassword($data["password"], $user["password"])) {
            ResponseHelper::jsonResponse(["error" => "Invalid email or password"], 401);
        }

        // Encode token
        $token = AuthHelper::encodeToken(["id" => $user["id"], "email" => $user["email"]]);
        ResponseHelper::jsonResponse(["token" => $token]);
    }
}
