<?php
include 'connection.php';
// Retrieve all comment from the database
$sql = "SELECT * FROM Comment";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $comment = array();
    while ($row = $result->fetch_assoc()) {
        $comment[] = $row;
    }
    // Convert the comment array to JSON
    $json = json_encode($comment, JSON_PRETTY_PRINT);

    // Set the response headers
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    // Output the JSON data
    echo $json;
} else {
    echo "No comment found.";
}
$conn->close();
?>