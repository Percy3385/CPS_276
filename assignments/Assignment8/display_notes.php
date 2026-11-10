<?php
require_once 'classes/date_time.php';

// Create an object from the Date_time class
$dt = new Date_time();

// Check if the Get Notes button was clicked
$notes = $dt->checkSubmit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Display Notes</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-3">

        <h1>Display Notes</h1>

        <p>
            <a href="index.php">Add Note</a>
        </p>

        <form method="post" action="display_notes.php" novalidate>

            <div class="mb-3">
                <label for="begDate" class="form-label">
                    Beginning Date
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="begDate"
                    name="begDate">
            </div>

            <div class="mb-3">
                <label for="endDate" class="form-label">
                    Ending Date
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="endDate"
                    name="endDate">
            </div>

            <button
                type="submit"
                name="getNotes"
                value="1"
                class="btn btn-primary mb-3">
                Get Notes
            </button>

        </form>

        <!-- Display the notes table or error message -->
        <?php echo $notes; ?>

    </div>
</body>

</html>