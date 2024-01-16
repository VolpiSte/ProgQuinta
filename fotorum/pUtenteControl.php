<?php
// Start the session
session_start();

// Include the database connection file
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['nickname'])) {
    // Send an error response
    http_response_code(403);
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user information
    $stmt = $conn->prepare('UPDATE Account SET name = ?, surname = ?, location = ?, work = ?, sex = ?, pronoun = ? WHERE nickname = ?');
    $stmt->bind_param('sssssss', $_POST['name'], $_POST['editSurname'], $_POST['editLocation'], $_POST['editWork'], $_POST['editSex'], $_POST['editPronoun'], $_SESSION['nickname']);
    $stmt->execute();

    // Fetch the updated user information
    $stmt = $conn->prepare('SELECT Account.*, Sex.sex, Pronoun.pronoun FROM Account 
                            INNER JOIN Sex ON Account.sex = Sex.id 
                            INNER JOIN Pronoun ON Account.pronoun = Pronoun.id 
                            WHERE nickname = ?');
    $stmt->bind_param('s', $_SESSION['nickname']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Send the updated user information as a JSON response
    echo json_encode($user);
} else {
    // Send an error response for invalid request method
    http_response_code(405);
}
?>
