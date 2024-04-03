<?php
    session_start();
    require 'connection.php';
    include 'errorCodes.php';
    // Retrieve verification_code from session variable
    $verification_code = $_SESSION['verification_code'];

    if (isset($_GET['error'])) {
        $errorCode = $_GET['error'];
        $errorMessage = isset($errorCodes[$errorCode]) ? $errorCodes[$errorCode] : 'Unknown Error';
        echo "<p class='error'>$errorMessage</p>";
    }
?>

<!DOCTYPE html>
<html>
    <body>

        <h2>Enter Code</h2>

        <form method="post" action="enterCode.php">
            Code: <input type="text" name="code">
            <input type="submit">
        </form>

        <script>
            // Print the verification_code to the console
            console.log(<?php echo json_encode($verification_code); ?>);
        </script>

    </body>
</html>