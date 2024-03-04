<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();

    include 'connection.php';
    $b = false;
    if (!isset($_SESSION['nickname'])) {
        header("Location: login.php");
        exit();
    }

    if (!isset($_POST['post_id'])) {
        echo "Post ID is required.";
        exit();
    }

    $postId = $_POST['post_id'];

    $stmt = $conn->prepare('SELECT Post.*, Account.nickname, Account.id as accountId FROM Post INNER JOIN Account ON Post.account_id = Account.id WHERE Post.id = ?');
    $stmt->bind_param('i', $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if ($post === null) {
        echo "Post not found.";
        exit();
    }

    $ownerId = $post['accountId'];

    if ($_SESSION['nickname'] !== $post['nickname']) {
        //echo "You are not the owner of this post.";
        $b = true;
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

<?php if (!$b): ?>
    <button id="showEditFormButton">Edit Post</button>
    <!-- Add edit button -->
    <form id="editForm" action="editPost.php" method="post" style="display: none;">
        <input type="hidden" id="editPostId" name="post_id" value="<?php echo $postId; ?>">
        <textarea id="editPostText" name="text" placeholder="New text"></textarea>
        <input type="file" id="editPostFile" name="file">
        <input type="submit" value="Save Changes">
    </form>
    <!-- Add delete button -->
    <form action="vPpostControl.php" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
        <input type="submit" value="Delete Post">
    </form>
<?php endif; ?>


<div id="menu">
    <a href="home.php">Home</a><br>
    <a href="logout.php">Logout</a><br>
</div>

<script>
var showEditFormButton = document.getElementById('showEditFormButton');
if (showEditFormButton) {
    showEditFormButton.addEventListener('click', function() {
        document.getElementById('editForm').style.display = 'block';
    });
}

var editForm = document.getElementById('editForm');
if (editForm) {
    editForm.addEventListener('submit', function(event) {
        event.preventDefault();

        var postId = document.getElementById('editPostId').value;
        var postText = document.getElementById('editPostText').value;
        var postFile = document.getElementById('editPostFile').files[0];

        var formData = new FormData();
        formData.append('action', 'edit');
        formData.append('post_id', postId);
        formData.append('text', postText);
        if (postFile) {
            formData.append('file', postFile);
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'vPpostControl.php', true);

        xhr.onload = function() {
            if (this.status == 200) {
                console.log(this.responseText);
                if (this.responseText.trim() == "Post updated successfully") {
                    // Optionally, reload the page if the update was successful
                    location.reload();
                }
            }
        };

        xhr.send(formData);
    });
}
</script>
</body>
</html>