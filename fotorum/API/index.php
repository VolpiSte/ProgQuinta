<!DOCTYPE html>
<html>
<head>
    <title>API</title>
</head>
<body>
    <h1>API</h1>
    <ul>
        <?php
        // Get the current directory
        $directory = __DIR__;
        
        // Get all files in the directory
        $files = scandir($directory);
        
        // Loop through the files
        foreach ($files as $file) {
            // Exclude current and parent directories
            if ($file != '.' && $file != '..') {
                // Check if the file is a PHP file
                if (pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                    // Generate a link to the file
                    $link = $file;
                    
                    // Output the link
                    echo "<li><a href=\"$link\">$file</a></li>";
                }
            }
        }
        ?>
    </ul>
</body>
</html>