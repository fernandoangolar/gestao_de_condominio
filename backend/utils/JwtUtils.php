<?php
// backend/utils/JwtUtils.php
require_once '../vendor/autoload.php';
use \Firebase\JWT\JWT;

class JwtUtils {
    public static function generateToken($userId, $role) {
        $payload = array(
            "iss" => "http://localhost",
            "aud" => "http://localhost",
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + (60*60), // 1 hora de validade
            "data" => array(
                "id" => $userId,
                "role" => $role
            )
        );

        return JWT::encode($payload, JWT_SECRET);
    }

    public static function validateToken($token) {
        try {
            $decoded = JWT::decode($token, JWT_SECRET, array('HS256'));
            return $decoded->data;
        } catch (Exception $e) {
            return null;
        }
    }
}
?>
