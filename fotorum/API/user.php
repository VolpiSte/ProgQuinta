<?php
include 'connection.php';

// Check if any parameters were provided in the URL
if (isset($_SERVER['PATH_INFO'])) {
    // Split the parameters into an array
    $params = explode('/', ltrim($_SERVER['PATH_INFO'], '/'));

    // The first parameter is the user ID
    $userId = $params[0];

    // Retrieve the user with the specified ID from the database
    $stmt = $conn->prepare("SELECT * FROM Account WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        // If a second parameter is provided, it specifies a type of data to retrieve
        if (isset($params[1])) {
            $type = $params[1];

            switch ($type) {
                case 'post':
                    $stmt = $conn->prepare("SELECT * FROM Post WHERE account_id = ?");
                    break;
                case 'like':
                    $stmt = $conn->prepare("SELECT * FROM Likes WHERE account_id = ?");
                    break;
                case 'comment':
                    $stmt = $conn->prepare("SELECT * FROM Comment WHERE account_id = ?");
                    break;
                default:
                    echo "Invalid type.";
                    exit();
            }

            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $user[$type] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        echo json_encode($user, JSON_PRETTY_PRINT);
    } else {
        echo "No user found.";
    }
} else {
    // Retrieve all users from the database
    $stmt = $conn->prepare("SELECT * FROM Account");
    $stmt->execute();
    $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    echo json_encode($users, JSON_PRETTY_PRINT);
}

$conn->close();
?>