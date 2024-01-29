<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();

    include 'connection.php';

    if (!isset($_SESSION['nickname'])) {
        header("Location: login.php");
        exit();
    }

    if (!isset($_POST['action']) || $_POST['action'] !== 'delete' || !isset($_POST['post_id'])) {
        echo "Invalid request.";
        exit();
    }

    $postId = $_POST['post_id'];

    $stmt = $conn->prepare('DELETE FROM Post WHERE id = ?');
    $stmt->bind_param('i', $postId);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        echo "Post not found or not deleted.";
        exit();
    }

    header("Location: pUtente.php");
?>