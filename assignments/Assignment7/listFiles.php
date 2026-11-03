<?php

require_once __DIR__ . "/php/listFilesProc.php";


/*
 * Retrieve uploaded files
 */
try {

    $files = getFiles();
} catch (Exception $e) {

    error_log($e->getMessage());

    $files = 'error';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1">

    <title>List Files</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body>

    <div class="container mt-3">

        <h1>List Files</h1>

        <p>
            <a href="index.php">Add File</a>
        </p>

        <?php

        if ($files === 'error') {

            echo '<p class="text-danger">';
            echo 'Could not retrieve files from database.';
            echo '</p>';
        } elseif (empty($files)) {

            echo "<p>No files have been uploaded.</p>";
        } else {

            echo "<ul>";

            foreach ($files as $file) {

                $fileName = htmlspecialchars(
                    $file['file_name'],
                    ENT_QUOTES,
                    'UTF-8'
                );

                $filePath = $file['file_path'];

                // Only allow PDF links inside the files folder.
                if (!preg_match(
                    '~^files/[a-f0-9]{32}\.pdf$~',
                    $filePath
                )) {
                    continue;
                }

                $filePath = htmlspecialchars(
                    $filePath,
                    ENT_QUOTES,
                    'UTF-8'
                );

                echo '<li>';

                echo '<a target="_blank" rel="noopener noreferrer" href="' .
                    $filePath . '">';

                echo $fileName;

                echo '</a>';

                echo '</li>';
            }

            echo "</ul>";
        }

        ?>

    </div>

</body>

</html>