<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
    try {
    // Handle photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_path = 'uploads/' . pathinfo($_FILES['photo']['name'], PATHINFO_FILENAME) . '.webp';

        // Create an image resource from the uploaded file
        $imageType = exif_imagetype($_FILES['photo']['tmp_name']);
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($_FILES['photo']['tmp_name']);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($_FILES['photo']['tmp_name']);
                break;
            default:
                throw new Exception('Invalid image type.');
        }

        // Convert the image to WEBP and save it
        imagewebp($image, $photo_path);

        // Free up memory
        imagedestroy($image);
    } else {
        $photo_path = NULL;
    }

    // Update user information
    $stmt = $conn->prepare('UPDATE Account SET name = ?, surname = ?, location = ?, work = ?, sex = ?, pronoun = ?, photo = ? WHERE nickname = ?');
    $stmt->bind_param('ssssssss', $_POST['name'], $_POST['editSurname'], $_POST['editLocation'], $_POST['editWork'], $_POST['editSex'], $_POST['editPronoun'], $photo_path, $_SESSION['nickname']);
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
            header('Content-Type: application/json');
            echo json_encode($user);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    } else {
        // Send an error response for invalid request method
        http_response_code(405);
    }

?>