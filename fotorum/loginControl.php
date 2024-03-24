<?php
    session_start();
    require 'connection.php';
    include 'errorCodes.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email_or_nickname = strip_tags($_POST['email_or_nickname']);
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM Account WHERE email = ? OR nickname = ?");
        $stmt->bind_param("ss", $email_or_nickname, $email_or_nickname);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($result->num_rows > 0) {
            $hashed_password = hash('sha3-512', $user['salt'] . $password);

            if ($user['verified']) {
                if ($hashed_password == $user['password']) {
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['nickname'] = $user['nickname'];
                    $_SESSION['role'] = $user['role'];

                    // Set the cookie for email or nickname
                    setcookie('email_or_nickname', $email_or_nickname, time() + (86400), "/", "", false, true); // 86400 = 1 day

                    if ($_SESSION['role'] == 3) {
                        header("Location: login.php?error=8");
                    } else if ($_SESSION['role'] == 4) {
                        header("Location: login.php?error=14");
                    } else {
                        header("Location: home.php");
                    }
                } else {
                    header("Location: login.php?error=1");
                }
            } else {
                $_SESSION['email'] = $user['email'];
                header("Location: registerConfirm.php");
                exit();
            }
        } else {
            header("Location: login.php?error=1");
        }
    }
?>