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
    $stmt = $conn->prepare('SELECT * FROM Account WHERE nickname = ?');
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
    // Display user information
    echo "<div id='user-info' class='cool-div'>";
    echo "<div><strong>Name:</strong> <span id='name'>{$user['name']}</span> <button id='nameButton' onclick='change(\"name\", \"{$user['name']}\")'>Change</button></div>";
    echo "<div><strong>Work:</strong> <span id='work'>{$user['work']}</span> <button id='workButton' onclick='change(\"work\", \"{$user['work']}\")'>Change</button></div>";
    echo "<div><strong>Sex:</strong> <span id='sex'>{$user['sex']}</span> <button id='sexButton' onclick='change(\"sex\", \"{$user['sex']}\")'>Change</button></div>";
    echo "<div><strong>Email:</strong> {$user['email']}</div>";
    echo "<div><strong>Nickname:</strong> {$user['nickname']}</div>";
    echo "<div><strong>Location:</strong> {$user['location']}</div>";
    echo "<div><strong>Nickname:</strong> {$user['nickname']}</div>";
    echo "<div><strong>Profile Picture:</strong> <img id='photo' src='{$user['photo']}' alt='Profile Picture' /></div>";
    echo "<div><a href='home.php'>Home</a></div>";
    echo "<div><a href='logout.php'>Logout</a></div>";
    echo "</div>";
?>
<script>
    function change(field, oldValue) {
        var span = document.getElementById(field);
        var button = document.getElementById(field + 'Button');

        // Create an input field and a confirm button
        var input = document.createElement('input');
        input.value = oldValue;
        var confirmButton = document.createElement('button');
        confirmButton.textContent = 'Conferma';

        // Replace the span and button with the input field and confirm button
        span.parentNode.replaceChild(input, span);
        button.parentNode.replaceChild(confirmButton, button);

        // When the confirm button is clicked, send an AJAX request to pUtenteControl.php
        confirmButton.addEventListener('click', function() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'pUtenteControl.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('field=' + encodeURIComponent(field) + '&value=' + encodeURIComponent(input.value));

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // If the request was successful, replace the input field and confirm button with the updated span and button
                    var newSpan = document.createElement('span');
                    newSpan.id = field;
                    newSpan.textContent = input.value;
                    var newButton = document.createElement('button');
                    newButton.id = field + 'Button';
                    newButton.textContent = 'Change';
                    newButton.setAttribute('onclick', 'change("' + field + '", "' + input.value + '")');

                    input.parentNode.replaceChild(newSpan, input);
                    confirmButton.parentNode.replaceChild(newButton, confirmButton);
                } else {
                    // If the request failed, alert the user
                    alert('Failed to update ' + field);
                }
            };
        });
    }
</script>