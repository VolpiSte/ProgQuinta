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

    if (!isset($_POST['action']) || !isset($_POST['post_id'])) {
        echo "Invalid request.";
        exit();
    }

    $postId = $_POST['post_id'];

    if ($_POST['action'] === 'delete') {
        $stmt = $conn->prepare('DELETE FROM Post WHERE id = ?');
        $stmt->bind_param('i', $postId);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            echo "Post not found or not deleted.";
            exit();
        }

        header("Location: pUtente.php");
    } elseif ($_POST['action'] === 'edit') {
        $text = $_POST['text'];

        // Handle file upload
        $file_path = NULL;
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $file_path = 'uploads/' . $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
        }

        $stmt = $conn->prepare("UPDATE Post SET text = ?, file = ? WHERE id = ?");
        $stmt->bind_param("ssi", $text, $file_path, $postId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Post updated successfully";
        } else {
            echo "Error updating post";
        }
    } else {
        echo "Invalid action.";
        exit();
    }
?>