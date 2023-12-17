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
            <input list="sex-options" id="sex" name="sex" placeholder="sex" required >
            <datalist id="sex-options" >
            </datalist><br>
            <div id="other-input" style="display: none;">
                <label>Please specify:</label>
                <input type="text" name="other-sex" placeholder="Specify your gender"><br>
            </div>
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
        <script>
            window.onload = function() {
                var sexInput = document.getElementById('sex');
                var otherInput = document.getElementById('other-input');
                var datalist = document.getElementById('sex-options');
                var genders = [];

                // Fetch the JSON file
                fetch('genders.json')
                    .then(response => response.json())
                    .then(data => {
                        genders = data;
                        // Create an <option> for each item in the JSON file
                        for (var i = 0; i < data.length; i++) {
                            var option = document.createElement('option');
                            option.value = data[i];
                            datalist.appendChild(option);
                        }
                    });

                sexInput.onchange = function() {
                    if (sexInput.value.toLowerCase() === 'other') {
                        otherInput.style.display = 'block';
                    } else {
                        otherInput.style.display = 'none';
                        if (!genders.includes(sexInput.value)) {
                            alert('Invalid gender. Please select a gender from the list or enter "Other".');
                            sexInput.value = '';
                        }
                    }
                }

                // Prevent form submission if the gender is not in the JSON file and not "Other"
                document.querySelector('form').onsubmit = function(e) {
                    if (!genders.includes(sexInput.value) && sexInput.value.toLowerCase() !== 'other') {
                        e.preventDefault();
                        alert('Invalid gender. Please select a gender from the list or enter "Other".');
                    }
                }
            }
        </script>
    </body>
</html>