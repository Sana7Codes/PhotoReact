<?php
require_once __DIR__ . '/../src/config/connection.php';
require_once __DIR__ . '/../src/routers/api.php';
require_once __DIR__ . '/../src/routers/Router.php';
require_once __DIR__ . '/../src/helpers/response.php';

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Parse the request URL and method
$requestUri = $_SERVER["REQUEST_URI"];
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Dynamically detect the project base path
$basePath = dirname($_SERVER["SCRIPT_NAME"]);
$processedUrl = str_replace($basePath, '', $requestUri);
$finalUrl = strtok($processedUrl, '?'); // Remove query strings

// Debugging Output (Remove in production)
if (isset($_GET['debug'])) {
    ResponseHelper::jsonResponse([
        "Request URI" => $requestUri,
        "Request Method" => $requestMethod,
        "Final Processed URL" => $finalUrl,
        "Debug" => "Checking registered routes..."
    ]);
}

// Dispatch the request through Router
Router::dispatch($finalUrl, $requestMethod);
