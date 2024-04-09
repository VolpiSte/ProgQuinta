<?php
// Connessione al database
require "connection.php";

// Verifica che la richiesta sia una richiesta POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controlla se sono stati passati i parametri richiesti
    if (isset($_POST['accountId']) && isset($_POST['newRoleId'])) {
        // Sanifica i dati per prevenire attacchi di tipo SQL injection
        $accountId = $_POST['accountId'];
        $newRoleId = $_POST['newRoleId'];

        // Query per aggiornare il ruolo dell'account nel database
        $updateQuery = "UPDATE account SET role = ? WHERE id = ?";
        
        // Prepara e esegui la query
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ii", $newRoleId, $accountId);
        $stmt->execute();

        // Controlla se l'aggiornamento è stato eseguito con successo
        if ($stmt->affected_rows > 0) {
            // Invia una risposta HTTP 200 (OK) per indicare che l'operazione è stata completata con successo
            http_response_code(200);
        } else {
            // Invia una risposta HTTP 500 (Internal Server Error) per indicare che si è verificato un errore durante l'aggiornamento del ruolo
            http_response_code(500);
            echo "Errore durante l'aggiornamento del ruolo.";
        }

        // Chiudi la connessione al database e termina lo script
        $stmt->close();
        $conn->close();
        exit();
    }
}

// Se non sono stati passati i parametri richiesti, invia una risposta HTTP 400 (Bad Request)
http_response_code(400);
echo "Parametri mancanti.";
?>
