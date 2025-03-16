<?php

class AuthHelper
{
    //  Encode user data as Base64 token
    public static function encodeToken($userData)
    {
        return base64_encode(json_encode($userData));
    }

    //  Decode Base64 token back to user data
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
    //  Hash passwords securely
    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    //  Verify password against hash
    public static function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }
}
