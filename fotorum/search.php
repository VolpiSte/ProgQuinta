<?php
    // Start the session
    session_start();

    // Include the database connection file
    include 'connection.php';

    // Get the search term from the POST data
    $searchTerm = $_POST['term'];

    // Add the wildcard character to the search term
    $searchTermWithWildcard = $searchTerm . '%';

    // Fetch matching accounts
    $stmt = $conn->prepare('SELECT id, nickname FROM Account WHERE nickname LIKE ? LIMIT 10');
    $stmt->bind_param('s', $searchTermWithWildcard);
    $stmt->execute();
    $result = $stmt->get_result();
    $accounts = $result->fetch_all(MYSQLI_ASSOC);

    // Return the accounts as a JSON array
    echo json_encode($accounts);
?>