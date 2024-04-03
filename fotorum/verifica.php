<?php
require_once 'vendor/autoload.php'; // Includi il file autoload.php fornito da Composer
require_once 'tokenJWT.php';

use \Firebase\JWT\JWT;


// Verifica il token passato come parametro
$token = $_POST['token'];

// Verifica se è stato fornito un token
if(empty($token)) {
    http_response_code(400);
    echo json_encode(array('message' => 'Token mancante.'));
    exit();
}

// Verifica il token
$decoded = verifyToken($token);

if ($decoded) {
    // Se il token è valido, restituisci i dati
    http_response_code(200);
    echo json_encode($decoded);
} else {
    // Se il token non è valido, restituisci un errore
    http_response_code(401);
    echo json_encode(array('message' => 'Token non valido.'));
}

exit();
?>
