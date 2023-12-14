<?php
    session_start();
    require 'connection.php';
    include 'errorCodes.php';
    // Retrieve email from session variable
    $email = $_SESSION['email'];
    // Store email in session variable
    $_SESSION['email'] = $email;

    // Retrieve the tempCode from the database for the current user
    $stmt = $conn->prepare("SELECT tempCode FROM Account WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $tempCode = $row['tempCode']; 
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
            // Print the tempCode to the console
            console.log(<?php echo json_encode($tempCode); ?>);
        </script>

    </body>
</html>