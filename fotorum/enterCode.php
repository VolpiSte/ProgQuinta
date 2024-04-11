<?php
session_start();
require 'connection.php';
include 'errorCodes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredCode = $_POST['code'];

    // Check if the session variable is set
    if (!isset($_SESSION['email'])) {
        header("Location: registerConfirm.php?error=9");
        exit();
    }

    // Retrieve the verification_code and expiration_date from the database for the current user
    $stmt = $conn->prepare("SELECT verification_code, expiration_date FROM Verify INNER JOIN account ON Verify.account_id = account.id WHERE account.email = ?");
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returned a result
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Compare the entered code with the verification_code
        if ($enteredCode == $row['verification_code']) {
            // Check if the code has expired
            $currentDateTime = new DateTime();
            $expirationDateTime = new DateTime($row['expiration_date']);

            if ($currentDateTime > $expirationDateTime) {
                // If the code has expired, delete the account
                $stmt = $conn->prepare("DELETE FROM account WHERE email = ?");
                $stmt->bind_param("s", $_SESSION['email']);
                $stmt->execute();

                header("Location: register.php?error=2");
            } else {
                // If the code has not expired, set the verified field to true for the account and delete the verification_code and expiration_date from the Verify table
                $stmt = $conn->prepare("UPDATE account SET verified = TRUE WHERE email = ?");
                $stmt->bind_param("s", $_SESSION['email']);
                $stmt->execute();

                $stmt = $conn->prepare("DELETE FROM Verify WHERE account_id = (SELECT id FROM account WHERE email = ?)");
                $stmt->bind_param("s", $_SESSION['email']);
                $stmt->execute();

                // Redirect to the login page
                header("Location: login.php");
            }
        } else {
            // If they don't match, redirect back to the enter code page with an error message
            header("Location: registerConfirm.php?error=9");
        }
    } else {
        // User not found in the database
        header("Location: registerConfirm.php?error=9");
    }
}
?>