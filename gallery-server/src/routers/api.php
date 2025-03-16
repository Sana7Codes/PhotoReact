<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/PhotoController.php';
require_once __DIR__ . '/../helpers/auth.php';
require_once __DIR__ . '/../helpers/response.php';
require_once __DIR__ . '/../routers/Router.php';

// Middleware to authenticate user
function authenticateUser()
{
    $headers = getallheaders();
    file_put_contents(__DIR__ . "/../logs/debug_headers.txt", print_r($headers, true));

    if (!isset($_SERVER["HTTP_AUTHORIZATION"]) && !isset($headers["Authorization"])) {
        ResponseHelper::jsonResponse(["error" => "Unauthorized - Missing Token"], 401);
        exit();
    }

    // Extract Token
    $base64Token = isset($_SERVER["HTTP_AUTHORIZATION"])
        ? str_replace("Bearer ", "", $_SERVER["HTTP_AUTHORIZATION"])
        : str_replace("Bearer ", "", $headers["Authorization"]);

    // Decode Token
    $userData = AuthHelper::decodeToken($base64Token);

    if (!$userData) {
        ResponseHelper::jsonResponse(["error" => "Unauthorized - Invalid Token"], 401);
        exit();
    }

    return $userData;
}
// User Authentication Routes
Router::add("POST", "/register", function () {
    $controller = new UserController();
    echo json_encode($controller->register());
});

Router::add("POST", "/login", function () {
    $controller = new AuthController();
    echo json_encode($controller->login());
});

// Protected Routes (Require Authentication)
Router::add("GET", "/photos", function () {
    authenticateUser();
    $controller = new PhotoController();
    $controller->getAllPhotos();
});

Router::add("POST", "/upload", function () {
    $userData = authenticateUser();
    if (!$userData) {
        ResponseHelper::jsonResponse(["error" => "Unauthorized-Invalid Taken"], 401);
        return;
    }

    $controller = new PhotoController();
    $controller->uploadPhoto($userData["id"]);
});

Router::add("GET", "/debug-routes", function () {
    ResponseHelper::jsonResponse(["routes" => Router::getRegisteredRoutes()]);
});
