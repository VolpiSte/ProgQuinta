<?php
require 'fotorum/src/JWT.php';
use \Firebase\JWT\JWT;

class VerifyController {
    public function verifyToken($token) {
        // The key used to sign the JWT
        $key = 'qualcosaCheNonIndovineraiMai';

        try {
            // Decode the token
            $decoded = JWT::decode($token, $key, array('HS256'));

            // If the token is valid, return the decoded data as JSON
            header('Content-Type: application/json');
            echo json_encode($decoded);
        } catch (\Firebase\JWT\ExpiredException $e) {
            // The token has expired
            http_response_code(401);
            echo 'Token has expired';
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            // The token is invalid
            http_response_code(401);
            echo 'Token is invalid';
        } catch (\Exception $e) {
            // Some other error occurred
            http_response_code(400);
            echo 'An error occurred';
        }
    }
}