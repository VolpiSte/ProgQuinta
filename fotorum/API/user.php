<?php
include 'connection.php';

// Check if an ID was provided in the URL
if (isset($_SERVER['PATH_INFO'])) {
    // Extract the ID
    $id = ltrim($_SERVER['PATH_INFO'], '/');

    // Retrieve the user with the specified ID from the database
    $sql = "SELECT * FROM Account WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
} else {
    // Retrieve all users from the database
    $sql = "SELECT * FROM Account";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $users = array();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    // Convert the users array to JSON
    $json = json_encode($users, JSON_PRETTY_PRINT);

    // Set the response headers
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    // Output the JSON data
    echo $json;
} else {
    echo "No users found.";
}

$stmt->close();
$conn->close();
?>