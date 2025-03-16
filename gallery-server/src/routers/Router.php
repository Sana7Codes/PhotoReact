<?php
file_put_contents(__DIR__ . "/../logs/debug_test.txt", "PHP can write to logs\n", FILE_APPEND);

class Router
{
    private static $routes = [];

    public static function add($method, $route, $callback)
    {
        self::$routes[] = compact("method", "route", "callback");
    }


    public static function dispatch($requestUrl, $requestMethod)
    {
        $headers = getallheaders();
        file_put_contents(__DIR__ . "/../logs/debug_router.txt", print_r($headers, true));

        foreach (self::$routes as $route) {
            if ($route["route"] === $requestUrl && $route["method"] === $requestMethod) {
                call_user_func($route["callback"]);
                return;
            }
        }
        ResponseHelper::jsonResponse(["error" => "Route not found"], 404);
    }
    public static function getRegisteredRoutes()
    {
        if (!isset(self::$routes) || !is_array(self::$routes)) {
            return ["error" => "No routes found"];
        }
        return array_map(function ($route) {
            return $route["method"] . " " . $route["route"];
        }, self::$routes);
    }
}
