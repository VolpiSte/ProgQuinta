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
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit();
    }

    // Fetch user information
    $stmt = $conn->prepare('SELECT account.*, sex.sex, pronoun.pronoun FROM account 
                            INNER JOIN sex ON account.sex = sex.id 
                            INNER JOIN pronoun ON account.pronoun = pronoun.id 
                            WHERE nickname = ?');
    $stmt->bind_param('s', $_SESSION['nickname']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if the user exists in the database
    if ($user === null) {
        // Redirect to login page if the user does not exist
        header("Location: login.php");
        exit();
    }

        // Fetch user posts
        $stmtPosts = $conn->prepare('SELECT * FROM post WHERE account_id = ?');
        $stmtPosts->bind_param('i', $user['id']);
        $stmtPosts->execute();
        $resultPosts = $stmtPosts->get_result();
    $posts = $resultPosts->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Personal Profile</title>
    <style>
    .profile-photo {
        max-width: 200px;  /* Or whatever width you want */
        max-height: 200px; /* Or whatever height you want */
        width: auto;
        height: auto;
    }

    .post-photo {
        max-width: 400px;  /* Or whatever width you want */
        max-height: 300px; /* Or whatever height you want */
        width: auto;
        height: auto;
    }
    </style>
</head>
<body>
<div id="userInfo">
    <!-- Visualizzazione delle informazioni -->
    <p>Name: <span id="name"><?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    <p>Surname: <span id="surname"><?php echo htmlspecialchars($user['surname'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    <p>Location: <span id="location"><?php echo htmlspecialchars($user['location'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    <p>Work: <span id="work"><?php echo htmlspecialchars($user['work'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    <p>Sex: <span id="sex"><?php echo htmlspecialchars($user['sex'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    <p>Pronoun: <span id="pronoun"><?php echo htmlspecialchars($user['pronoun'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    <p>Image Profile:</p>
    <img id="imageProfile" class="profile-photo" src="<?php echo htmlspecialchars($user['photo'], ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Image">
</div>
<button id="editButton" type="button">Edit</button>

<!-- Edit form (hidden by default) -->
<div id="editForm" style="display: none;">
    <form id="updateForm" method="POST" enctype="multipart/form-data">
        Name: <input type="text" id="editName" name="name" value="<?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?>"><br>
        Surname: <input type="text" name="editSurname" value="<?php echo htmlspecialchars($user['surname'], ENT_QUOTES, 'UTF-8'); ?>"><br>
        Location: <input type="text" name="editLocation" value="<?php echo htmlspecialchars($user['location'], ENT_QUOTES, 'UTF-8'); ?>"><br>
        Work: <input type="text" name="editWork" value="<?php echo htmlspecialchars($user['work'], ENT_QUOTES, 'UTF-8'); ?>"><br>
        <label>Sex:</label>
        <select id="editSexSelect" name="editSex" required>
            <?php
                include 'connection.php';
                // Fetch the options for the Sex field
                $result = $conn->query("SELECT id, sex FROM sex ORDER BY sex");
                while ($roi = $result->fetch_assoc()) {
                    echo "<option value='" . $roi['id'] . "'" . ($user['sex'] == $roi['sex'] ? ' selected' : '') . ">" . $roi['sex'] . "</option>";
                }
            ?>
        </select><br>
        <label>Pronoun:</label>
        <select id="editPronounSelect" name="editPronoun" required>
            <?php
                // Fetch the options for the Pronoun field
                $result = $conn->query("SELECT id, pronoun FROM pronoun");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'" . ($user['pronoun'] == $row['pronoun'] ? ' selected' : '') . ">" . $row['pronoun'] . "</option>";
                }
            ?>
        </select><br>
        <label>Profile Image:</label>
        <input type="file" id="editPhoto" name="photo"><br>
        <input type="submit" value="Update">
        <button type="button" id="cancelButton">Cancel</button>
    </form>
</div>

<!-- Display user posts -->
<div id="userPosts">
    <h2>User Posts:</h2>
    <?php
    if (empty($posts)) {
        echo "<p>No posts found.</p>";
    } else {
        foreach ($posts as $post) {
            echo "<div class='post'>";
            echo "<p>Text: " . htmlspecialchars($post['text'], ENT_QUOTES, 'UTF-8') . "</p>";

            // Display photo if available
            if (!empty($post['photo'])) {
                echo "<img class='post-photo' src='" . htmlspecialchars($post['photo'], ENT_QUOTES, 'UTF-8') . "' alt='Post Photo'>";
            }

            // Add a form to post the post ID to vPost.php
            echo "<form action='vPpost.php' method='post'>";
            echo "<input type='hidden' name='post_id' value='" . $post['id'] . "'>";
            echo "<input type='submit' value='View Post'>";
            echo "</form>";
            echo "</div>";
        }
    }
    ?>
</div>


<div id="menu">
    <a href="resetPassword.php">Reset PASSWORD</a><br>
    <a href="post.php">Create Post</a><br>
    <a href="home.php">Home</a><br>
    <a href="logout.php">Logout</a><br>
</div>


<!-- JavaScript -->
<script>
document.getElementById('editButton').addEventListener('click', function() {
    var form = document.getElementById('editForm');
    var userInfo = document.getElementById('userInfo');
    var editButton = document.getElementById('editButton'); // Aggiunto questo

    if (form.style.display === 'none') {
        // Nascondi le informazioni visualizzate quando si fa clic su "Edit"
        userInfo.style.display = 'none';
        form.style.display = 'block';
        editButton.style.display = 'none'; // Nascondi il pulsante "Edit"
    } else {
        // Mostra nuovamente le informazioni quando si fa clic su "Cancel"
        userInfo.style.display = 'block';
        form.style.display = 'none';
        editButton.style.display = 'block'; // Mostra nuovamente il pulsante "Edit"
    }
});

document.getElementById('updateForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'pUtenteControl.php', true);
    xhr.onload = function() {
        if (this.status == 200) {
            console.log(this.responseText);
            var user = JSON.parse(this.responseText);
            console.log(user);
            // Update displayed information with edited ones
            document.getElementById('name').textContent = user.name;
            document.getElementById('surname').textContent = user.surname;
            document.getElementById('location').textContent = user.location;
            document.getElementById('work').textContent = user.work;
            document.getElementById('sex').textContent = user.sex;
            document.getElementById('pronoun').textContent = user.pronoun;
            // Update the profile image
            document.getElementById('imageProfile').src = user.photo;

            // Hide the edit form and display the information again
            document.getElementById('editForm').style.display = 'none';
            document.getElementById('userInfo').style.display = 'block';
            document.getElementById('editButton').style.display = 'block'; // Show the "Edit" button again
        }
    };
    xhr.send(formData);
});

document.getElementById('cancelButton').addEventListener('click', function() {
    // Mostra nuovamente le informazioni quando si fa clic su "Cancel"
    document.getElementById('editForm').style.display = 'none';
    document.getElementById('userInfo').style.display = 'block';
    document.getElementById('editButton').style.display = 'block'; // Mostra nuovamente il pulsante "Edit"
});
</script>
</body>
</html>
