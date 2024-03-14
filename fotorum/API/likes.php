<?php
include 'connection.php';
// Retrieve all likes from the database
$sql = "SELECT * FROM Likes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $likes = array();
    while ($row = $result->fetch_assoc()) {
        $likes[] = $row;
    }
    // Convert the likes array to JSON
    $json = json_encode($likes, JSON_PRETTY_PRINT);

    // Set the response headers
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    // Output the JSON data
    echo $json;
} else {
    echo "No likes found.";
}
$conn->close();
?>