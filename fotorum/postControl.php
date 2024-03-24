<?php
session_start();
require 'connection.php';
include 'errorCodes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST['text'];
    $nickname = $_SESSION['nickname'];

    // Retrieve the account_id from the database
    $stmt = $conn->prepare("SELECT id FROM Account WHERE nickname = ?");
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $result = $stmt->get_result();
    $account = $result->fetch_assoc();

    // Check if an account was found
    if ($account) {
        $account_id = $account['id'];

        // Check if a photo was uploaded
        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] != 0) {
            header("Location: post.php?error=15" . $ERROR_CODE_PHOTO_REQUIRED);
            exit();
        }

        // Save the original photo in the downloads/ folder
        $original_photo_path = 'downloads/' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $original_photo_path);

        // Create an image resource from the uploaded file
        $imageType = exif_imagetype($original_photo_path);
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($original_photo_path);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($original_photo_path);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($original_photo_path);
                break;
            default:
                throw new Exception('Invalid image type.');
        }

        // Convert the image to WEBP and save it
        $photo_path = 'fPostS/' . pathinfo($_FILES['photo']['name'], PATHINFO_FILENAME) . '.webp';
        imagewebp($image, $photo_path);

        // Free up memory
        imagedestroy($image);

        // Handle file upload
        $file_path = NULL;
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $file_path = 'pPresets/' . $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
        }

        // Insert the post into the database, including the original photo path
        $stmt = $conn->prepare("INSERT INTO Post (text, photo, original_photo, file, account_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $text, $photo_path, $original_photo_path, $file_path, $account_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: pUtente.php");
        } else {
            header("Location: post.php?error=13");
        }
    } else {
        // Account not found, handle the error
        echo "Account not found for nickname or email: " . $nickname_or_email;
    }
}
?>