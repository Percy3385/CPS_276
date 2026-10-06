<?php
/*
Question 1:
The purpose of separating index.php and processNames.php functions 
of presentation and processing
*/
// Start with an empty list of names.
$names = "";
// If processNames.php sends names back through the URL,
// store them in the $names variable.
if (isset($_GET["names"])) {
    $names = $_GET["names"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Name List</title>
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Name List</h1>
        <!--
        The form sends its information to processNames.php
        using the POST method.
    -->
        <form action="processNames.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">
                    Enter Name
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name">
            </div>
            <div class="mb-3">
                <!--
            Both buttons have the same name ("action"),
                but different values.
            processNames.php can check the value to see
                which button the user clicked.
            -->
                <button
                    type="submit"
                    class="btn btn-primary"
                    name="action"
                    value="add">
                    Add Name
                </button>
                <button
                    type="submit"
                    class="btn btn-danger"
                    name="action"
                    value="clear">
                    Clear Names
                </button>
            </div>
            <div class="mb-3">
                <label for="names" class="form-label">
                    Names
                </label>
                <!--
            The textarea stores the current list of names.
                htmlspecialchars() prevents special HTML characters
                from being interpreted as HTML.
            -->
                <textarea
                    class="form-control"
                    id="names"
                    name="names"
                    rows="10"><?php echo htmlspecialchars($names); ?></textarea>
            </div>
        </form>
    </div>
</body>

</html>