<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Create Post</title>
    </head>
    <body>
        <?php
        
        include 'errorCodes.php';
        if (isset($_GET['error'])) {
            $error_code = $_GET['error'];
            if (isset($errorCodes[$error_code])) {
                echo "<p style='color:red;'>Error: " . $errorCodes[$error_code] . "</p>";
            }
        }
        ?>
        <form action="postControl.php" method="post" enctype="multipart/form-data">
            Photo: <input type="file" name="photo" accept="image/*"><br>
            File: <input type="file" name="file" accept=".xmp,.dng,.lrtemplate"><br>
            Text: <textarea name="text"></textarea><br>
            <input type="submit" value="Create Post">
        </form>
        <a href="home.php">Home</a><br>
        <a href="pUtente.php">Personal Profile</a><br>
        <a href="logout.php">Logout</a><br>
    </body>
</html>