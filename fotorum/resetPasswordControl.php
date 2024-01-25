<?php
    session_start();
    require 'connection.php';
    include 'errorCodes.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = strip_tags($_POST['password']);
        $confirm_password = strip_tags($_POST['confirm_password']);

        if ($password !== $confirm_password) {
            header("Location: resetPassword.php?error=4"); // Error code 4 for password mismatch
            exit();
        }

        // If the user is logged in, use the nickname from the session
        // Otherwise, get the email or nickname from the form
        $email_or_nickname = isset($_SESSION['nickname']) ? $_SESSION['nickname'] : strip_tags($_POST['email_or_nickname']);

        // Retrieve the old salt and hashed password from the database
        $stmt = $conn->prepare("SELECT salt, password FROM Account WHERE email = ? OR nickname = ?");
        $stmt->bind_param("ss", $email_or_nickname, $email_or_nickname);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Check if the old password is the same as the new one
        $old_hashed_password = $user['password'];
        $old_salt = $user['salt'];
        if (hash('sha3-512', $old_salt . $password) === $old_hashed_password) {
            header("Location: resetPassword.php?error=12"); // Error code 12 for same old and new password
            exit();
        }

        // Generate a new salt and hashed password
        $salt = bin2hex(random_bytes(32));
        $hashed_password = hash('sha3-512', $salt . $password);

        // Prepare an UPDATE statement
        $stmt = $conn->prepare("UPDATE Account SET password = ?, salt = ? WHERE email = ? OR nickname = ?");
        $stmt->bind_param("ssss", $hashed_password, $salt, $email_or_nickname, $email_or_nickname);

        // Execute the statement
        $stmt->execute();

        // Redirect to the login page
        header("Location: home.php");
        exit;
    }
?>