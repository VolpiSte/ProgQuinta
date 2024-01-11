<?php
    session_start();
    require 'connection.php';
    include 'errorCodes.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email_or_nickname = strip_tags($_POST['email_or_nickname']);
        $password = $_POST['password'];
    
        // Retrieve the salt, hashed password and role from the database
        $stmt = $conn->prepare("SELECT * FROM Account WHERE email = ? OR nickname = ?");
        $stmt->bind_param("ss", $email_or_nickname, $email_or_nickname);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Check if the query returned a result
        if ($result->num_rows > 0) {
            // Combine the provided password with the salt and hash the result
            $hashed_password = hash('sha3-512', $user['salt'] . $password);

            // If the account is verified, check the password
            if ($user['verified']) {
                if ($hashed_password == $user['password']) {
                    // If the password is correct, log in the user
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['nickname'] = $user['nickname'];
                    $_SESSION['role'] = $user['role']; // Store the user's role in the session

                    // Set the cookie for email or nickname
                    setcookie('email_or_nickname', $email_or_nickname, time() + (86400), "/"); // 86400 = 1 day

                    // Check the user's role and redirect them to the appropriate page
                    if ($_SESSION['role'] == '0') {
                        header("Location: home.php");
                    } else {
                        // If the role is not '0', redirect back to the login page
                        header("Location: login.php?error=8");
                    }
                } else {
                    // If the password is incorrect, redirect back to the login page with an error message
                    header("Location: login.php?error=1");
                }
            } else {
                // If the account is not verified, redirect to the register confirmation page
                $_SESSION['email'] = $user['email'];
                header("Location: registerConfirm.php");
                exit();
            }
        } else {
            // User not found in the database
            header("Location: login.php?error=1");
        }
    }
?>