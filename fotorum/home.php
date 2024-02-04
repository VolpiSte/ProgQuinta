<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <style>
            body {
                font-family: sans-serif;
                background-color: #f4f4f4;
                text-align: center;
                margin: 150px;
            }
            form {
                display: inline-block;
                text-align: left;
            }
            .error {
                color: red;
            }
            .post {
                border: 1px solid #ccc;
                padding: 10px;
                margin: 10px 0;
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
        <?php
            session_start();

            if (isset($_SESSION['nickname'])) {
                echo("<h1>Hello, " . $_SESSION['nickname'] . "</h1>");
            } elseif (isset($_COOKIE['nickname'])) {
                echo("<h1>Hello, " . $_COOKIE['nickname'] . "</h1>");
            } else {
                header("Location: login.php");
                exit;
            }

            // Include the database connection file
            include 'connection.php';
        
            // Fetch the latest 3 posts along with the account nickname
            $stmtPosts = $conn->prepare('SELECT Post.*, Account.nickname FROM Post INNER JOIN Account ON Post.account_id = Account.id ORDER BY Post.id DESC LIMIT 3');
            $stmtPosts->execute();
            $resultPosts = $stmtPosts->get_result();
            $posts = $resultPosts->fetch_all(MYSQLI_ASSOC);
        ?>
                <input type="text" id="searchTerm" oninput="search()">
        <div id="searchResults"></div>
        <a href="pUtente.php">Personal Profile</a><br>
        <a href="post.php">Create Post</a><br>
        <a href=""></a><br>
        <a href="logout.php">Logout</a><br>

        <div id="latestPosts">
    <h2>Latest Posts:</h2>
    <?php
    if (empty($posts)) {
        //echo "<p>No posts found.</p>";
    } else {
        foreach ($posts as $post) {
            echo "<div class='post'>";
            echo "<p>Creator: " . htmlspecialchars($post['nickname'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p>Text: " . htmlspecialchars($post['text'], ENT_QUOTES, 'UTF-8') . "</p>";

            // Display photo if available
            if (!empty($post['photo'])) {
                echo "<img class='post-photo' src='" . htmlspecialchars($post['photo'], ENT_QUOTES, 'UTF-8') . "' alt='Post Photo'>";
            }

            // Display file if available
            if (!empty($post['file'])) {
                echo "<p>File: <a href='" . htmlspecialchars($post['file'], ENT_QUOTES, 'UTF-8') . "'>Download</a></p>";
            }

            echo "</div>";
        }
    }
    ?>
</div>
        <script>
            var loggedInUserNickname = <?php echo json_encode($_SESSION['nickname']); ?>;
            function search() {
                var searchTerm = document.getElementById('searchTerm').value;

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'search.php', true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var accounts = JSON.parse(xhr.responseText);
                        var resultsDiv = document.getElementById('searchResults');
                        resultsDiv.innerHTML = '';

                        for (var i = 0; i < accounts.length; i++) {
                            var a = document.createElement('a');
                            if (accounts[i].nickname === loggedInUserNickname) {
                                a.href = 'pUtente.php';
                            } else {
                                a.href = 'vUtente.php?id=' + encodeURIComponent(accounts[i].id);
                            }
                            a.textContent = accounts[i].nickname;
                            resultsDiv.appendChild(a);
                            resultsDiv.appendChild(document.createElement('br'));
                        }
                    }
                };
                xhr.send("term=" + encodeURIComponent(searchTerm));
            }
        </script>
    </body>
</html>