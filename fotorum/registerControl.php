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
    $photo = $_FILES['photo']['tmp_name'];
    $dataCode = NULL;
    $validate = FALSE;

    // Convert boolean to integer for MySQL
    $validate = $validate ? 1 : 0;

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

    // Check if file was uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $file = $_FILES['photo'];

        // Check file extension
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if ($ext != 'ico') {
            header("Location: register.php?error=7");
            exit();
        }
        
        // Check image dimensions
        $imageSize = getimagesize($file['tmp_name']);
        if ($imageSize[0] > 256 || $imageSize[1] > 256) {
            header("Location: register.php?error=8");
            exit();
        }
    }

    // Handle photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_path = 'uploads/' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    } else {
        $photo_path = NULL;
    }

    // Generate a random 8 digit number
    $tempCode = rand(10000000, 99999999);

    // Generate the current date and time
    $dataCode = date('Y-m-d H:i:s');

    // Assumi un valore di default per $role (aggiustalo in base alle tue esigenze)
    $role = 'default_role';

    // Insert new user into the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO Account (name, surname, nickname, email, password, dateBorn, location, sex, work, role, photo, tempCode, dataCode, validate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssssi", $name, $surname, $nickname, $email, $hashed_password, $dateBorn, $location, $sex, $work, $role, $photo_path, $tempCode, $dataCode, $validate);
    $stmt->execute();
    
    // Redirect to login page
    // Store email in session variable
    $_SESSION['email'] = $email;

    header("Location: registerConfirm.php");
}
?>
