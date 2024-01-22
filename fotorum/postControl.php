<?php
session_start();
require 'connection.php';
include 'errorCodes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST['text'];
    $nickname = $_SESSION['nickname'];

    // Retrieve the account_id from the database
    $stmt = $conn->prepare("SELECT id FROM Account WHERE nickname = ?");
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $result = $stmt->get_result();
    $account = $result->fetch_assoc();

    // Check if an account was found
    if ($account) {
        $account_id = $account['id'];

        // Handle photo upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $photo_path = 'uploads/' . $_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
        } else {
            $photo_path = NULL;
        }

        // Handle file upload
        $file_path = NULL;
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $file_path = 'uploads/' . $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
        }

        $stmt = $conn->prepare("INSERT INTO Post (text, photo, file, account_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $text, $photo_path, $file_path, $account_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: pUtente.php");
        } else {
            header("Location: post.php?error=13");
        }
    } else {
        // Account not found, handle the error
        echo "Account not found for nickname or email: " . $nickname_or_email;
    }
}
?>