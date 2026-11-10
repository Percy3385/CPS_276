<?php
require_once 'classes/date_time.php';

// Create an object from the Date_time class
$dt = new Date_time();

// Check if the Add Note button was clicked
$notes = $dt->checkSubmit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Add Note</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-3">

        <h1>Add Note</h1>

        <p>
            <a href="display_notes.php">Display Notes</a>
        </p>

        <form method="post" action="index.php" novalidate>

            <!-- Display success or error messages -->
            <?php echo $notes; ?>

            <div class="mb-3">
                <label for="dateTime" class="form-label">
                    Date and Time
                </label>

                <input
                    type="datetime-local"
                    class="form-control"
                    id="dateTime"
                    name="dateTime">
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">
                    Note
                </label>

                <textarea
                    class="form-control"
                    id="note"
                    name="note"
                    rows="10"></textarea>
            </div>

            <button
                type="submit"
                name="addNote"
                value="1"
                class="btn btn-primary">
                Add Note
            </button>

        </form>

    </div>
</body>

</html>