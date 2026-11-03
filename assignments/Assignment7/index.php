<?php

$success = isset($_GET['success']) &&
    $_GET['success'] === '1';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1">

    <title>File Upload</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body>

    <div class="container mt-3">

        <h1>File Upload</h1>

        <p>
            <a href="listFiles.php">Show File List</a>
        </p>

        <?php if ($success): ?>

            <div class="alert alert-success">
                File uploaded successfully.
            </div>

        <?php endif; ?>

        <form
            action="php/fileUploadProc.php"
            method="post"
            enctype="multipart/form-data">

            <div class="mb-3">

                <label for="fileName" class="form-label">
                    File Name
                </label>

                <input
                    type="text"
                    class="form-control"
                    id="fileName"
                    name="fileName"
                    maxlength="250"
                    required>

            </div>

            <div class="mb-3">

                <input
                    type="file"
                    name="uploadFile"
                    id="uploadFile"
                    accept=".pdf,application/pdf"
                    required>

            </div>

            <button
                type="submit"
                class="btn btn-primary">
                Upload File
            </button>

        </form>

    </div>

</body>

</html>