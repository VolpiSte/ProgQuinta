<?php
    session_start();
    require 'connection.php';
    include 'errorCodes.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = strip_tags($_POST['name']);
        $surname = strip_tags($_POST['surname']);
        $nickname = strip_tags($_POST['nickname']);
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        $confirm_password = strip_tags($_POST['confirm_password']);
        $dateBorn = strip_tags($_POST['dateBorn']);
        $location = strip_tags($_POST['location']);
        $sex = strip_tags($_POST['sex']);
        $pronoun = strip_tags($_POST['pronoun']);
        $work = strip_tags($_POST['work']);
        $role = 1; // Default role is 'user'
        $photo = $_FILES['photo']['tmp_name'];

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
        $stmt = $conn->prepare("SELECT * FROM account WHERE email = ? OR nickname = ?");
        $stmt->bind_param("ss", $email, $nickname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: register.php?error=6");
            exit();
        }

        // Handle photo upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $photo_path = 'fProfile/' . pathinfo($_FILES['photo']['name'], PATHINFO_FILENAME) . '.webp';

            // Create an image resource from the uploaded file
            $imageType = exif_imagetype($_FILES['photo']['tmp_name']);
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($_FILES['photo']['tmp_name']);
                    break;
                case IMAGETYPE_GIF:
                    $image = imagecreatefromgif($_FILES['photo']['tmp_name']);
                    break;
                case IMAGETYPE_WEBP:
                    if (function_exists('imagecreatefromwebp')) {
                        $image = imagecreatefromwebp($_FILES['photo']['tmp_name']);
                    } else {
                        throw new Exception('WEBP support not enabled.');
                    }
                    break;
                default:
                    throw new Exception('Invalid image type.');
            }

            // Convert the image to WEBP and save it
            imagewebp($image, $photo_path);

            // Free up memory
            imagedestroy($image);
        } else {
            $photo_path = NULL;
        }

        // Generate a random salt
        $salt = bin2hex(random_bytes(32));

        // Combine the salt with the password and hash the result
        $hashed_password = hash('sha3-512', $salt . $password);

        // Fetch the sex ID based on the provided sex value
        $stmt = $conn->prepare("SELECT id FROM sex WHERE sex = ?");
        $stmt->bind_param("s", $sex);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            // Il valore di sex non esiste nella tabella Sex
            header("Location: register.php?error=7");
            exit();
        }

        $row = $result->fetch_assoc();
        $sex_id = $row['id'];

        // Ora puoi utilizzare $sex_id nella tua query di inserimento in account
        $stmt = $conn->prepare("INSERT INTO account (name, surname, nickname, email, password, salt, dateBorn, sex, pronoun, location, work, role, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, (SELECT id FROM Role WHERE role = ?), ?)");
        $stmt->bind_param("sssssssssssss", $name, $surname, $nickname, $email, $hashed_password, $salt, $dateBorn, $sex_id, $pronoun, $location, $work, $role, $photo_path);
        $stmt->execute();


        // Get the id of the newly created account
        $account_id = $conn->insert_id;

        // Generate a unique verification code
        $verification_code = bin2hex(random_bytes(4)); // generates an 8 characters long code

        // Set the expiration date for the verification code
        $expiration_date = date("Y-m-d H:i:s", strtotime("+1 day")); // code expires after 1 day

        // Insert the verification code into the Verify table
        $stmt = $conn->prepare("INSERT INTO verify (account_id, verification_code, expiration_date) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $account_id, $verification_code, $expiration_date);
        $stmt->execute();

        // Redirect to registerConfirm.php
        // Store email and verification_code in session variables
        $_SESSION['email'] = $email;
        $_SESSION['verification_code'] = $verification_code;

        header("Location: registerConfirm.php");
    }
?>