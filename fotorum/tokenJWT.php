<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/fotorum/src/JWT.php');
use \Firebase\JWT\JWT;

// Chiave segreta per firmare/verificare i token JWT
define('SECRET_KEY', 'qualcosaCheNonIndovineraiMai'); // Cambia questa chiave con una segreta sicura

// Funzione per generare un token JWT
function generateToken($user_id) {
    // Contenuto del token
    $payload = array(
        "user_id" => $user_id
    );
    // Genera il token JWT
    $token = JWT::encode($payload, SECRET_KEY, 'HS256');
    return $token;
}

// Esempio di utilizzo della funzione
// $user_id è l'identificatore dell'utente autenticato
// $token = generateToken($user_id);

?>
