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
            <input type="password" id="password" name="password" placeholder="password" required><br>

            <label>Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required><br>

            <input type="checkbox" onclick="togglePasswordVisibility()">Show Passwords<br>

            <label>Date of Birth:</label>
            <input type="date" name="dateBorn" required><br>
            <label>Location:</label>
            <input type="text" name="location" placeholder="location" required><br>
            <label>Sex:</label>
            <input list="sexes" name="sex" value="Male" required>
            <datalist id="sexes">
                <?php
                    include 'connection.php';
                    // Fetch the options for the Sex field
                    $result = $conn->query("SELECT id, sex FROM sex ORDER BY sex");
                    while ($row = $result->fetch_assoc()) {
                        $sex = strip_tags($row['sex']);
                        echo "<option value='" . $sex . "'>";
                    }
                ?>
            </datalist><br>
            <label>Pronoun:</label>
            <select id="pronoun" name="pronoun" required>
                <?php
                    // Fetch the options for the Pronoun field
                    $result = $conn->query("SELECT id, pronoun FROM pronoun");
                    while ($row = $result->fetch_assoc()) {
                        $id = strip_tags($row['id']);
                        $pronoun = strip_tags($row['pronoun']);
                        $selected = $pronoun == 'he' ? 'selected' : '';
                        echo "<option value='" . $id . "' " . $selected . ">" . $pronoun . "</option>";
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

    <script>
            function togglePasswordVisibility() {
                var passwordInput = document.getElementById("password");
                var confirmPasswordInput = document.getElementById("confirm_password");
                
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    confirmPasswordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                    confirmPasswordInput.type = "password";
                }
            }
            </script>
</html>