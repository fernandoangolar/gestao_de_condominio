<?php
// backend/utils/AuthMiddleware.php
require_once 'JwtUtils.php';

class AuthMiddleware {
    public static function authorize() {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            $userData = JwtUtils::validateToken($token);
            if ($userData) {
                return $userData;
            }
        }
        Response::send(401, array("message" => "Unauthorized"));
        exit();
    }

    public static function authorizeAdmin() {
        $userData = self::authorize();
        if ($userData->role !== 'admin') {
            Response::send(403, array("message" => "Forbidden"));
            exit();
        }
    }
}
?>
