<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                text-align: center;
                margin: 150px;
            }
            form {
                display: inline-block;
                text-align: left;
            }
            .error {
                color: red;
            }
        </style>
    </head>
    <body>
        <?php
            session_start();

            if (isset($_SESSION['nickname'])) {
                echo("<h1>Hello, " . $_SESSION['nickname'] . "</h1>");
            } elseif (isset($_COOKIE['nickname'])) {
                echo("<h1>Hello, " . $_COOKIE['nickname'] . "</h1>");
            } else {
                header("Location: login.php");
                exit;
            }
        ?>
        <a href="pUtente.php">View User Information</a><br>
        <a href="post.php">Create Post</a><br>
        <a href="logout.php">Logout</a><br>

    </body>
</html>