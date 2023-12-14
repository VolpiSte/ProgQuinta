<?php
session_start();
require 'connection.php';
include 'errorCodes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailOrNickname = $_POST['email_or_nickname']; // Change variable name
    $password = $_POST['password'];

    // Retrieve the user's data from the database
    $stmt = $conn->prepare("SELECT * FROM Account WHERE email = ? OR nickname = ?");
    $stmt->bind_param("ss", $emailOrNickname, $emailOrNickname);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if the user exists
    if ($user) {
        // Check if the account is validated
        if ($user['validate'] == 0) { // Change to 0 for false
            // Check if it's been more than 1 minute since the account was created
            $currentDateTime = new DateTime();
            $dataCodeDateTime = new DateTime($user['dataCode']);
            $interval = $currentDateTime->diff($dataCodeDateTime);

            if ($interval->i > 1) {
                // If it's been more than 1 minute, delete the account
                $stmt = $conn->prepare("DELETE FROM Account WHERE email = ? OR nickname = ?");
                $stmt->bind_param("ss", $emailOrNickname, $emailOrNickname);
                $stmt->execute();

                header("Location: register.php?error=2");
                exit();
            } else {
                // If it's been less than 1 minute, redirect to the register confirmation page
                $_SESSION['email'] = $user['email'];
                header("Location: registerConfirm.php");
                exit();
            }
        } else {
            // If the account is validated, check the password
            if (password_verify($password, $user['password'])) {
                // If the password is correct, log in the user
                $_SESSION['email'] = $user['email'];
                $_SESSION['nickname'] = $user['nickname']; // Store the nickname in the session

                // Set a cookie with the user's nickname that expires in 30 days
                setcookie('nickname', $user['nickname'], time() + 86400, "/"); // 86400 = 1 day

                header("Location: home.php");
                exit();
            } else {
                // If the password is incorrect, redirect back to the login page with an error message
                header("Location: login.php?error=3");
                exit();
            }
        }
    } else {
        // If the user doesn't exist, redirect back to the login page with an error message
        header("Location: login.php?error=1");
        exit();
    }
}
?>