<?php
session_start();
include 'connection.php';

if (!isset($_POST['post_id'], $_POST['account_id'])) {
    echo "Post ID and Account ID are required.";
    exit();
}

$postId = $_POST['post_id'];
$accountId = $_POST['account_id'];

$stmt = $conn->prepare('INSERT INTO Likes (post_id, account_id) VALUES (?, ?)');
$stmt->bind_param('ii', $postId, $accountId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Like added successfully";
} else {
    echo "Failed to add like";
}
?>
