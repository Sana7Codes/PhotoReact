<?php
class Base64Helper
{
    public static function decodeBase64Image($base64String)
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
            return ["error" => "Invalid image format"];
        }

        $imageType = strtolower($matches[1]); // Extract file extension (png, jpg, etc.)
        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];

        if (!in_array($imageType, $allowedExtensions)) {
            return ["error" => "Unsupported image format"];
        }

        $imageBase64 = preg_replace('/^data:image\/\w+;base64,/', '', $base64String);
        $imageData = base64_decode($imageBase64, true);

        if ($imageData === false) {
            return ["error" => "Base64 decoding failed"];
        }

        return ["data" => $imageData, "extension" => $imageType];
    }
}
