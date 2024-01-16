<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <style>
            body {
                font-family: Arial, sans-serif;
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
        </style>
    </head>
    <body>
        <h2>Register</h2>
        <form method="post" action="registerControl.php" enctype="multipart/form-data">
            <label>Name:</label>
            <input type="text" name="name" placeholder="name" required><br>
            <label>Surname:</label>
            <input type="text" name="surname" placeholder="surname" required><br>
            <label>Nickname:</label>    
            <input type="text" name="nickname" placeholder="nickname" required><br>
            <label>Email:</label>
            <input type="email" name="email" placeholder="email" required><br>
            <label>Password:</label>
            <input type="password" name="password" placeholder="password" required><br>
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" placeholder="Confirm your password" required><br>
            <label>Date of Birth:</label>
            <input type="date" name="dateBorn" required><br>
            <label>Location:</label>
            <input type="text" name="location" placeholder="location" required><br>
            <label>Sex:</label>
            <select id="sex" name="sex" required>
                <?php
                    include 'connection.php';
                    // Fetch the options for the Sex field
                    $result = $conn->query("SELECT id, sex FROM Sex");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['sex'] . "</option>";
                    }
                ?>
            </select><br>
            <label>Pronoun:</label>
            <select id="pronoun" name="pronoun" required>
                <?php
                    // Fetch the options for the Pronoun field
                    $result = $conn->query("SELECT id, pronoun FROM Pronoun");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['pronoun'] . "</option>";
                    }
                ?>
            </select><br>
            <label>Work:</label>
            <input type="text" name="work" placeholder="work" required><br>
            <label>Photo:</label>
            <input type="file" name="photo"><br>
            <?php
                include 'errorCodes.php';

                if (isset($_GET['error'])) {
                    $errorCode = $_GET['error'];
                    $errorMessage = isset($errorCodes[$errorCode]) ? $errorCodes[$errorCode] : 'Unknown Error';
                    echo "<p class='error'>$errorMessage</p>";
                }
            ?>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </body>
</html>