<?php
    // Start the session
    session_start();

    // Include the database connection file
    include 'connection.php';

    // Get the search term from the POST data
    $searchTerm = $_POST['term'];

    // If the search term matches the nickname of the logged-in user, redirect to pUtente.php
    if (isset($_SESSION['nickname']) && $searchTerm === $_SESSION['nickname']) {
        header('Location: pUtente.php');
        exit;
    }

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

