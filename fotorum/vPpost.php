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

    if (!isset($_POST['post_id'])) {
        echo "Post ID is required.";
        exit();
    }

    $postId = $_POST['post_id'];

    $stmt = $conn->prepare('SELECT * FROM Post WHERE id = ?');
    $stmt->bind_param('i', $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if ($post === null) {
        echo "Post not found.";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Post</title>
    <style>
    .post-photo {
        max-width: 400px;
        max-height: 300px;
        width: auto;
        height: auto;
    }
    </style>
</head>
<body>
<div id="post">
    <h2>Post:</h2>
    <p>Text: <span id="text"><?php echo htmlspecialchars($post['text'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    <?php
        if (!empty($post['photo'])) {
            echo "<img class='post-photo' src='" . htmlspecialchars($post['photo'], ENT_QUOTES, 'UTF-8') . "' alt='Post Photo'>";
        }
    ?>
</div>
<!-- Add delete button -->
<form action="vPpostControl.php" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
    <input type="submit" value="Delete Post">
</form>
<a href="pUtente.php">Back to Profile</a>
</body>
</html>