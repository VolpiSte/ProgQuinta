<?php
    // Start the session
    session_start();

    // Include the database connection file
    include 'connection.php';

    // Get the id of the user from the URL parameters
    $id = $_GET['id'];

    // Fetch the user data from the database
    $stmt = $conn->prepare('SELECT Account.*, Sex.sex, Pronoun.pronoun FROM Account 
                            LEFT JOIN Sex ON Account.sex = Sex.id 
                            LEFT JOIN Pronoun ON Account.pronoun = Pronoun.id 
                            WHERE Account.id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Store the user data in the session
    $_SESSION['user'] = $user;

    // Display user information
    echo "Name: " . $user['name'] . "<br>";
    echo "Surname: " . $user['surname'] . "<br>";
    echo "Nickname: " . $user['nickname'] . "<br>";
    echo "Date of Birth: " . $user['dateBorn'] . "<br>";
    echo "Sex: " . $user['sex'] . "<br>";
    echo "Pronoun: " . $user['pronoun'] . "<br>";
    echo "Location: " . $user['location'] . "<br>";
    echo "Work: " . $user['work'] . "<br>";
    echo "Photo: <img src='" . $user['photo'] . "' alt='User photo'><br>";

    // Fetch the posts of the user
    $stmt = $conn->prepare('SELECT photo, file, text FROM Post WHERE account_id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);

    // Display the posts
    if (count($posts) > 0) {
        echo "Posts:<br>";
        foreach ($posts as $post) {
            echo "Photo: <img src='" . $post['photo'] . "' alt='Post photo'><br>";
            echo "File: <a href='" . $post['file'] . "'>Download file</a><br>";
            echo "Text: " . $post['text'] . "<br><br>";
        }
    } else {
        echo "No posts yet.<br>";
    }
?>
<div id="menu">
    <a href="home.php">Home</a><br>
    <a href="logout.php">Logout</a><br>
</div>