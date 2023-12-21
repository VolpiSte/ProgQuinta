<?php
    session_start();
    require 'connection.php';
    include 'errorCodes.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $nickname = $_POST['nickname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $dateBorn = $_POST['dateBorn'];
        $location = $_POST['location'];
        $sex = $_POST['sex'];
        $work = $_POST['work'];
        $role = 0;
        $photo = $_FILES['photo']['tmp_name'];

        // If "sex" is "Other", replace it with the value from the "other-sex" input
        if (strtolower($sex) === 'other') {
            $sex = $_POST['other-sex'];
        }

        // Check if the user is at least 16 years old and not born in the future
        $dateBornDateTime = new DateTime($dateBorn);
        $currentDateTime = new DateTime();
        if ($dateBornDateTime > $currentDateTime) {
            header("Location: register.php?error=11"); 
            exit();
        }
        $interval = $dateBornDateTime->diff($currentDateTime);
        $age = $interval->y;
        if ($age < 16) {
            header("Location: register.php?error=10");
            exit();
        }

        // Validate form data
        if ($password != $confirm_password) {
            header("Location: register.php?error=4"); 
            exit();
        }

        // Check if nickname is at least 4 characters long
        if (strlen($nickname) < 4) {
            header("Location: register.php?error=5");
            exit();
        }

        // Check if email or nickname already exists
        $stmt = $conn->prepare("SELECT * FROM Account WHERE email = ? OR nickname = ?");
        $stmt->bind_param("ss", $email, $nickname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: register.php?error=6");
            exit();
        }

        // Handle photo upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $photo_path = 'uploads/' . $_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
        } else {
            $photo_path = NULL;
        }

        // Generate a random salt
        $salt = bin2hex(random_bytes(32));

        // Combine the salt with the password and hash the result
        $hashed_password = hash('sha3-512', $salt . $password);

        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO Account (name, surname, nickname, email, password, salt, dateBorn, location, sex, work, role, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $name, $surname, $nickname, $email, $hashed_password, $salt, $dateBorn, $location, $sex, $work, $role, $photo_path);
        $stmt->execute();

        // Get the id of the newly created account
        $account_id = $conn->insert_id;

        // Generate a unique verification code
        $verification_code = bin2hex(random_bytes(4)); // generates an 8 characters long code

        // Set the expiration date for the verification code
        $expiration_date = date("Y-m-d H:i:s", strtotime("+1 day")); // code expires after 1 day

        // Insert the verification code into the Verify table
        $stmt = $conn->prepare("INSERT INTO Verify (account_id, verification_code, expiration_date) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $account_id, $verification_code, $expiration_date);
        $stmt->execute();

        // Redirect to registerConfirm.php
        // Store email and verification_code in session variables
        $_SESSION['email'] = $email;
        $_SESSION['verification_code'] = $verification_code;

        header("Location: registerConfirm.php");
    }
?>