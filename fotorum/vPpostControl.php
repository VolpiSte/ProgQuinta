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
    } elseif ($_POST['action'] === 'like') {
    $nickname = $_SESSION['nickname'];
    $stmt = $conn->prepare('SELECT id FROM Account WHERE nickname = ?');
    $stmt->bind_param('s', $nickname);
    $stmt->execute();
    $result = $stmt->get_result();
    $account = $result->fetch_assoc();

    if ($account === null) {
        echo "Account not found.";
        exit();
    }

    $accountId = $account['id'];

    // Check if a like already exists
    $stmt = $conn->prepare("SELECT * FROM Likes WHERE post_id = ? AND account_id = ?");
    $stmt->bind_param("ii", $postId, $accountId);
    $stmt->execute();
    $like = $stmt->get_result()->fetch_assoc();

    if ($like) {
        // If a like exists, delete it
        $stmt = $conn->prepare("DELETE FROM Likes WHERE post_id = ? AND account_id = ?");
        $stmt->bind_param("ii", $postId, $accountId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Like removed successfully";
        } else {
            echo "Error removing like";
        }
    } else {
        // If no like exists, add one
        $stmt = $conn->prepare("INSERT INTO Likes (post_id, account_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $postId, $accountId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Like added successfully";
            echo '<form id="redirectForm" action="vPpost.php" method="post">
                <input type="hidden" name="post_id" value="' . $postId . '">
            </form>
            <script type="text/javascript">
                document.getElementById("redirectForm").submit();
            </script>';
        } else {
            echo "Error adding like";
        }
    }

    header("Location: vPpost.php");
    exit();
}
?>