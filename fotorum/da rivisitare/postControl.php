<?php
session_start();
require 'connection.php';
include 'errorCodes.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST['text'];

    $photo = $_FILES['photo'];
    $photo_path = 'uploads/' . basename($photo['name']);
    move_uploaded_file($photo['tmp_name'], $photo_path);

    $file = $_FILES['file'];
    $file_path = 'uploads/' . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $file_path);

    $stmt = $conn->prepare("INSERT INTO Posts (text, photo, file) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $text, $photo_path, $file_path);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: home.php");
    } else {
        header("Location: createPost.php?error=1");
    }
}
?>