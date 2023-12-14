<?php
session_start();
require 'connection.php';
include 'errorCodes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredCode = $_POST['code'];

    // Verifica se la variabile di sessione è impostata
    if (!isset($_SESSION['email'])) {
        header("Location: registerConfirm.php?error=9");
        exit();
    }

    // Retrieve the tempCode and dataCode from the database for the current user
    $stmt = $conn->prepare("SELECT tempCode, dataCode FROM Account WHERE email = ?");
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se la query ha restituito un risultato
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Compare the entered code with the tempCode
        if ($enteredCode == $row['tempCode']) {
            // Check if it's been more than 1 minute since the code was generated
            $currentDateTime = new DateTime();
            $dataCodeDateTime = new DateTime($row['dataCode']);
            $interval = $currentDateTime->diff($dataCodeDateTime);

            if ($interval->i > 1) {
                // If it's been more than 1 minute, delete the account
                $stmt = $conn->prepare("DELETE FROM Account WHERE email = ?");
                $stmt->bind_param("s", $_SESSION['email']);
                $stmt->execute();

                header("Location: register.php?error=2");
            } else {
                // If it's been less than 1 minute, update the validate field to TRUE
                $stmt = $conn->prepare("UPDATE Account SET validate = TRUE WHERE email = ?");
                $stmt->bind_param("s", $_SESSION['email']);
                $stmt->execute();

                header("Location: login.php");
            }
        } else {
            // If they don't match, redirect back to the enter code page with an error message
            header("Location: registerConfirm.php?error=9");
        }
    } else {
        // Utente non trovato nel database
        header("Location: registerConfirm.php?error=9");
    }
}
?>
