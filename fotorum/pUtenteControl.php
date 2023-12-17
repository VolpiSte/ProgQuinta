<?php
    // Start the session
    session_start();

    // Include the database connection file
    include 'connection.php';

    // Check if the user is logged in
    if (!isset($_SESSION['nickname'])) {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit();
    }

    // Get the field and value from the POST data
    $field = $_POST['field'];
    $value = $_POST['value'];

    // Prepare and execute the update statement
    $stmt = $conn->prepare('UPDATE Account SET ' . $field . ' = ? WHERE nickname = ?');
    $stmt->bind_param('ss', $value, $_SESSION['nickname']);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        echo 'Success';
    } else {
        http_response_code(500);
        echo 'Failed to update ' + $field;
    }
?>