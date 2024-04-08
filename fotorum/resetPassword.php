<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <?php
    session_start();
    include 'errorCodes.php';
    if (isset($_GET['error'])) {
        $error_code = $_GET['error'];
        if (isset($errorCodes[$error_code])) {
            echo "<p style='color:red;'>Error: " . $errorCodes[$error_code] . "</p>";
        }
    }
    ?>
    <form action="resetPasswordControl.php" method="POST">
        <?php
        if (!isset($_SESSION['nickname'])) {
        ?>
            <label for="email_or_nickname">Email or Nickname:</label>
            <input type="text" id="email_or_nickname" name="email_or_nickname" required>
            <br><br>
        <?php
        }
        ?>
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <br><br>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>