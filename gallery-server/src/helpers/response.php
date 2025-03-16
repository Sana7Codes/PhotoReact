
<?php

class ResponseHelper
{
    //  Send JSON response with specified HTTP status code
    public static function jsonResponse($data, int $statusCode = 200)
    {
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code($statusCode);

        //  Ensure proper JSON encoding
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        if ($json === false) {
            $json = json_encode(["error" => "JSON encoding error"]);
            http_response_code(500);
        }

        echo $json;
        exit();
    }

    //  Return an error response with message and status code
    public static function errorResponse($message, int $statusCode = 400)
    {
        self::jsonResponse(["error" => $message], $statusCode);
    }

    //  Return a success response with message and optional data
    public static function successResponse($message, array $data = [], int $statusCode = 200)
    {
        self::jsonResponse(array_merge(["success" => $message], $data), $statusCode);
    }
}
