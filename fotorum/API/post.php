<?php
include 'connection.php';

// Check if a user ID was provided in the URL
if (isset($_SERVER['PATH_INFO'])) {
    // Extract the user ID
    $userId = ltrim($_SERVER['PATH_INFO'], '/');

    // Retrieve all posts from the specified user from the database
    $sql = "SELECT * FROM Post WHERE userId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
} else {
    // Retrieve all posts from the database
    $sql = "SELECT * FROM Post";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $posts = array();
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    // Convert the posts array to JSON
    $json = json_encode($posts, JSON_PRETTY_PRINT);

    // Set the response headers
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    // Output the JSON data
    echo $json;
} else {
    echo "No posts found.";
}

$stmt->close();
$conn->close();
?>