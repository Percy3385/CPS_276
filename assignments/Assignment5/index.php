<?php
// Question 5:
// Include the class so we can use its methods.
// This keeps the file operations separate from the HTML.
require_once "classes/directories.php";
$message = "";
// Question 2:
// Check whether the user submitted the form.
// POST sends the form information to this PHP page.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $_POST gets the values entered in the form.
    // The names must match the HTML name attributes.
    // trim() removes extra spaces around the folder name.
    $folderName = trim($_POST["folderName"] ?? "");
    $fileContent = $_POST["fileContent"] ?? "";
    // Create an object from our Directories class.
    $directories = new Directories();
    // Call the method to create the folder and text file.
    // The method returns a message that we display below.
    $message = $directories->createDirectory(
        $folderName,
        $fileContent
    );
}
?>
<!DOCTYPE html>
<html lang="en">

<head> 
    <meta charset="UTF-8">
    <title>File and Directory Assignment</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>
    <div class="container mt-2">
        <h1>File and Directory Assignment</h1>
        <p>
            Enter a folder name and the contents of a file.
            Folder names should contain alpha numeric characters only.
        </p>
        <?php
        // Display the success or error message.
        // The class provides the message and optional file link.
        echo $message;
        ?>
        <!-- Question 2:
         The form uses POST to send information to index.php.
         Each field has a name that PHP uses with $_POST.
         The required and pattern attributes also help
         validate the information before submission. 
    -->
        <form method="post" action="index.php">
            <div class="mb-3">
                <label for="folderName" class="form-label">
                    Folder Name
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="folderName"
                    name="folderName"
                    pattern="[A-Za-z0-9]+"
                    required>
            </div>
            <div class="mb-3">
                <label for="fileContent" class="form-label">
                    File Content
                </label>
                <textarea
                    class="form-control"
                    id="fileContent"
                    name="fileContent"
                    rows="6"
                    required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </form>
    </div>
</body>

</html>