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

    // Check if the user has already liked the post
    $stmt = $conn->prepare("SELECT * FROM Likes WHERE post_id = ? AND account_id = ?");
    $stmt->bind_param("ii", $postId, $accountId);
    $stmt->execute();
    $like = $stmt->get_result()->fetch_assoc();

    $buttonText = $like ? "Remove Like" : "Like";

    // Count the number of likes for the post
$stmt = $conn->prepare("SELECT COUNT(*) as like_count FROM Likes WHERE post_id = ?");
$stmt->bind_param("i", $postId);
$stmt->execute();
$likeCountResult = $stmt->get_result();
$likeCount = $likeCountResult->fetch_assoc()['like_count'];

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
            // Add download button for the photo
            echo "<a href='" . htmlspecialchars($post['original_photo'], ENT_QUOTES, 'UTF-8') . "' download>Download Photo</a>\n";
        }
        if (!empty($post['file'])) {
            // Add download button for the file
            echo "<a href='" . htmlspecialchars($post['file'], ENT_QUOTES, 'UTF-8') . "' download>Scarica Preset</a>";
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
<!-- Add like button -->
<form id="likeForm" action="vPpostControl.php" method="post">
    <input type="hidden" name="action" value="like">
    <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
    <input type="hidden" name="account_id" value="<?php echo $accountId; ?>">
    <input type="submit" value="<?php echo $buttonText; ?>">
    <!-- Display the number of likes -->
    <span><?php echo $likeCount; ?> Likes</span>
</form>

<!-- Add comment button -->
<button id="showCommentFormButton">Commenta</button>
<!-- Add comment form -->
<form id="commentForm" action="vPpostControl.php" method="post" style="display: none;">
    <input type="hidden" name="action" value="comment">
    <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
    <input type="hidden" name="account_id" value="<?php echo $accountId; ?>">
    <textarea name="text" placeholder="Add a comment"></textarea>
    <input type="submit" value="Add Comment">
</form>

<!-- Display comments -->
<div id="comments">
    <?php
    $stmt = $conn->prepare('SELECT Comment.*, Account.nickname FROM Comment INNER JOIN Account ON Comment.account_id = Account.id WHERE Comment.post_id = ? ORDER BY Comment.id DESC');
    $stmt->bind_param('i', $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($comment = $result->fetch_assoc()) {
        echo "<div class='comment'>";
        echo "<p>" . htmlspecialchars($comment['nickname'], ENT_QUOTES, 'UTF-8') . ": " . htmlspecialchars($comment['text'], ENT_QUOTES, 'UTF-8') . "</p>";
        if ($accountId === $comment['account_id']) {
            echo "<button class='deleteCommentButton' data-comment-id='" . $comment['id'] . "'>Delete Comment</button>";
        }
        echo "</div>";
    }
    ?>
</div>

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

var likeForm = document.getElementById('likeForm');
if (likeForm) {
    likeForm.addEventListener('submit', function(event) {
        event.preventDefault();

        var action = this.elements['action'].value;
        var postId = this.elements['post_id'].value;
        var accountId = this.elements['account_id'].value;

        var formData = new FormData();
        formData.append('action', action);
        formData.append('post_id', postId);
        formData.append('account_id', accountId);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'vPpostControl.php', true);

        xhr.onload = function() {
            if (this.status == 200) {
                console.log(this.responseText);
                var response = JSON.parse(this.responseText);
                if (response.status === 'success') {
                    // Change the button text
                    var buttonText = response.message === 'Like added successfully' ? 'Rimuovi Like' : 'Like';
                    likeForm.querySelector('input[type="submit"]').value = buttonText;
                }
            }
        };
        xhr.send(formData);
    });
}

var commentForm = document.getElementById('commentForm');
if (commentForm) {
    commentForm.addEventListener('submit', function(event) {
        event.preventDefault();

        var action = this.elements['action'].value;
        var postId = this.elements['post_id'].value;
        var accountId = this.elements['account_id'].value;
        var text = this.elements['text'].value;

        var formData = new FormData();
        formData.append('action', action);
        formData.append('post_id', postId);
        formData.append('account_id', accountId);
        formData.append('text', text);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'vPpostControl.php', true);

        xhr.onload = function() {
            if (this.status == 200) {
                console.log(this.responseText);
                var response = JSON.parse(this.responseText);
                if (response.status === 'success') {
                    // Optionally, reload the page if the comment was added successfully
                    location.reload();
                }
            }
        };
        xhr.send(formData);
    });
}

// Add event listeners for delete comment buttons
var deleteCommentButtons = document.getElementsByClassName('deleteCommentButton');
for (var i = 0; i < deleteCommentButtons.length; i++) {
    deleteCommentButtons[i].addEventListener('click', function() {
        var commentId = this.getAttribute('data-comment-id');
        var postId = <?php echo json_encode($postId); ?>;
        var formData = new FormData();
        formData.append('action', 'deleteComment');
        formData.append('comment_id', commentId);
        formData.append('post_id', postId);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'vPpostControl.php', true);

        xhr.onload = function() {
            if (this.status == 200) {
                console.log(this.responseText);
                var response = JSON.parse(this.responseText);
                if (response.status === 'success') {
                    // Optionally, reload the page if the comment was deleted successfully
                    location.reload();
                }
            }
        };
        xhr.send(formData);
    });
}
var showCommentFormButton = document.getElementById('showCommentFormButton');
if (showCommentFormButton) {
    showCommentFormButton.addEventListener('click', function() {
        document.getElementById('commentForm').style.display = 'block';
    });
}
</script>
</script>
</body>
</html>