<?php
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
    $stmt = $conn->prepare('SELECT Account.*, Sex.sex, Pronoun.pronoun FROM Account 
                            INNER JOIN Sex ON Account.sex = Sex.id 
                            INNER JOIN Pronoun ON Account.pronoun = Pronoun.id 
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
        $stmtPosts = $conn->prepare('SELECT * FROM Post WHERE account_id = ?');
        $stmtPosts->bind_param('i', $user['id']);
        $stmtPosts->execute();
        $resultPosts = $stmtPosts->get_result();
    $posts = $resultPosts->fetch_all(MYSQLI_ASSOC);

?>

<div id="userInfo">
    <!-- Visualizzazione delle informazioni -->
    <p>Name: <span id="name"><?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    <p>Surname: <span id="surname"><?php echo htmlspecialchars($user['surname'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    <p>Location: <span id="location"><?php echo htmlspecialchars($user['location'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    <p>Work: <span id="work"><?php echo htmlspecialchars($user['work'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    <p>Sex: <span id="sex"><?php echo htmlspecialchars($user['sex'], ENT_QUOTES, 'UTF-8'); ?></span></p>
    <p>Pronoun: <span id="pronoun"><?php echo htmlspecialchars($user['pronoun'], ENT_QUOTES, 'UTF-8'); ?></span></p>
</div>
<button id="editButton" type="button">Edit</button>

<!-- Edit form (hidden by default) -->
<div id="editForm" style="display: none;">
    <form id="updateForm" method="POST">
        Name: <input type="text" id="editName" name="name" value="<?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?>"><br>
        Surname: <input type="text" name="editSurname" value="<?php echo htmlspecialchars($user['surname'], ENT_QUOTES, 'UTF-8'); ?>"><br>
        Location: <input type="text" name="editLocation" value="<?php echo htmlspecialchars($user['location'], ENT_QUOTES, 'UTF-8'); ?>"><br>
        Work: <input type="text" name="editWork" value="<?php echo htmlspecialchars($user['work'], ENT_QUOTES, 'UTF-8'); ?>"><br>
        <label>Sex:</label>
        <select id="editSexSelect" name="editSex" required>
            <?php
                // Fetch the options for the Sex field
                $result = $conn->query("SELECT id, sex FROM Sex");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'" . ($user['sex'] == $row['sex'] ? ' selected' : '') . ">" . $row['sex'] . "</option>";
                }
            ?>
</select><br>
        <label>Pronoun:</label>
        <select id="editPronounSelect" name="editPronoun" required>
            <?php
                // Fetch the options for the Pronoun field
                $result = $conn->query("SELECT id, pronoun FROM Pronoun");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'" . ($user['pronoun'] == $row['pronoun'] ? ' selected' : '') . ">" . $row['pronoun'] . "</option>";
                }
            ?>
        </select><br>
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
            //echo "<p>Post ID: " . htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p>Text: " . htmlspecialchars($post['text'], ENT_QUOTES, 'UTF-8') . "</p>";

            // Display photo if available
            if (!empty($post['photo'])) {
                echo "<img src='" . htmlspecialchars($post['photo'], ENT_QUOTES, 'UTF-8') . "' alt='Post Photo'>";
            }

            // You can display other post information as needed
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
            var user = JSON.parse(this.responseText);

            // Aggiorna le informazioni visualizzate con quelle modificate
            document.getElementById('name').textContent = user.name;
            document.getElementById('surname').textContent = user.surn3333333333333320ame;
            document.getElementById('location').textContent = user.location;
            document.getElementById('work').textContent = user.work;
            document.getElementById('sex').textContent = user.sex;
            document.getElementById('pronoun').textContent = user.pronoun;

            // Nascondi il form di modifica e mostra nuovamente le informazioni
            document.getElementById('editForm').style.display = 'none';
            document.getElementById('userInfo').style.display = 'block';
            document.getElementById('editButton').style.display = 'block'; // Mostra nuovamente il pulsante "Edit"
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
