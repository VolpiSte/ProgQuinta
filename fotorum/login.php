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
        <h2>Login</h2>
        <form method="post" action="loginControl.php">
        <label>Email or Nickname:</label>
        <input type="text" name="email_or_nickname" required value="<?php echo isset($_COOKIE['email_or_nickname']) ? $_COOKIE['email_or_nickname'] : ''; ?>"><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
            <?php
                include 'errorCodes.php';
                include 'genders.php';

                if (isset($_GET['error'])) {
                    $errorCode = $_GET['error'];
                    $errorMessage = isset($errorCodes[$errorCode]) ? $errorCodes[$errorCode] : 'Unknown Error';
                    echo "<p class='error'>$errorMessage</p>";
                }
            ?>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
        <br><br>
    </body>
</html>