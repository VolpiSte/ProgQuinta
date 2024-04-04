<?php
// import jwt
require_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;

// Chiave segreta per firmare/verificare i token JWT
define('SECRET_KEY', 'qualcosaCheNonIndovineraiMai'); // Cambia questa chiave con una segreta sicura

// Funzione per generare un token JWT
function generateToken($user) {
    // Contenuto del token
    $payload = array(
        "user_id" => $user['id'],
        "nickname" => $user['nickname'],
        "email" => $user['email'],
        "name" => $user['name'],
        "surname" => $user['surname']
    );
    // Genera il token JWT
    $token = JWT::encode($payload, SECRET_KEY, 'HS256');
    return $token;
}

// Esempio di utilizzo della funzione
// $user è un array con le informazioni dell'utente autenticato
// $token = generateToken($user);

?>