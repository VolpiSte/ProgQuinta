<?php
// Start the session
session_start();

require 'connection.php';
include 'errorCodes.php';

// Get the id of the user from the URL parameters
if (!isset($_GET['id'])) {
    echo $errorCodes[16];
    echo "<br><a href='home.php'>Home</a><br>";
    exit;
}
$id = $_GET['id'];

// Fetch the user data from the database
$stmt = $conn->prepare('SELECT account.*, sex.sex, pronoun.pronoun FROM account 
                        LEFT JOIN sex ON account.sex = sex.id 
                        LEFT JOIN pronoun ON account.pronoun = pronoun.id 
                        WHERE account.id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo $errorCodes[16];
    echo "<br><a href='home.php'>Home</a><br>";
    exit;
}

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
echo "Photo: <img src='" . $user['photo'] . "' alt='User photo' class='profile-photo'><br>";

// Display Change Role button
echo "<select onchange=\"changeRole(" . $id . ", this.value)\">";
// Fetch roles from the role table
$rolesQuery = "SELECT * FROM role";
$rolesResult = $conn->query($rolesQuery);
if ($rolesResult->num_rows > 0) {
    while ($roleRow = $rolesResult->fetch_assoc()) {
        // Set the selected attribute for the current user's role
        $selected = ($roleRow['id'] == $user['role']) ? "selected" : "";
        echo "<option value='" . $roleRow["id"] . "' $selected>" . $roleRow["description"] . "</option>";
    }
}
echo "</select>";

// Fetch the posts of the user
$stmt = $conn->prepare('SELECT id, photo, file, text FROM post WHERE account_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);
// Display the posts
if (count($posts) > 0) {
    echo "Posts:<br>";
    foreach ($posts as $post) {
        echo "Photo: <img class='post-photo' src='" . $post['photo'] . "' alt='Post photo' ><br>";
        echo "Text: " . $post['text'] . "<br><br>";
        echo "<form action='vPpost.php' method='post'>";
        echo "<input type='hidden' name='post_id' value='" . $post['id'] . "'>";
        echo "<input type='submit' value='View Post'>";
        echo "</form>";
    }
} else {
    echo "No posts yet.<br>";
}
?>

<div id="menu">
    <a href="home.php">Home</a><br>
    <a href="logout.php">Logout</a><br>
</div>
<head>
    <title>View Post</title>
    <style>
        .post-photo {
            max-width: 400px;
            max-height: 300px;
            width: auto;
            height: auto;
        }
        .profile-photo {
        max-width: 200px;  /* Or whatever width you want */
        max-height: 200px; /* Or whatever height you want */
        width: auto;
        height: auto;
        }
    </style>
</head>
