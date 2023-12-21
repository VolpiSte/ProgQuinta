<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
</head>
<body>
    <form action="postControl.php" method="post" enctype="multipart/form-data">
        Photo: <input type="file" name="photo" accept="image/*"><br>
        File: <input type="file" name="file" accept=".xmp,.dng,.lrtemplate"><br>
        Text: <textarea name="text"></textarea><br>
        <input type="submit" value="Create Post">
    </form>
</body>
</html>