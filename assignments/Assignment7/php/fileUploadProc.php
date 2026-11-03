<?php

require_once "../classes/Pdo_methods.php";


/*
 * Display an error message and return to upload form
 */
function uploadError($message)
{

    http_response_code(400);

    echo "<h2>Upload Error</h2>";

    echo "<p>" .
        htmlspecialchars($message, ENT_QUOTES, 'UTF-8') .
        "</p>";

    echo '<a href="../index.php">Try Again</a>';

    exit;
}


/*
 * Only process POST requests
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: ../index.php");
    exit;
}


/*
 * Get display name
 */
$fileName = trim($_POST['fileName'] ?? '');

if ($fileName === '' || strlen($fileName) > 250) {

    uploadError("Please enter a valid file name.");
}


/*
 * Check that a file was selected
 */
if (
    !isset($_FILES['uploadFile']) ||
    $_FILES['uploadFile']['error'] === UPLOAD_ERR_NO_FILE
) {

    uploadError("Please choose a PDF file.");
}


/*
 * Get uploaded file information
 */
$file = $_FILES['uploadFile'];


/*
 * Check for upload errors
 */
if ($file['error'] !== UPLOAD_ERR_OK) {

    uploadError("An error occurred while uploading the file.");
}


/*
 * Maximum file size: 5 MB
 */
$maxSize = 5 * 1024 * 1024;

if ($file['size'] <= 0 || $file['size'] > $maxSize) {

    uploadError("File is too large. Maximum size is 5 MB.");
}


/*
 * Verify that the file came from an HTTP upload
 */
if (!is_uploaded_file($file['tmp_name'])) {

    uploadError("Invalid file upload.");
}


/*
 * Validate PDF extension
 */
$fileExtension = strtolower(
    pathinfo($file['name'], PATHINFO_EXTENSION)
);

if ($fileExtension !== 'pdf') {

    uploadError("Only PDF files are allowed.");
}


/*
 * Validate actual file type
 */
$finfo = new finfo(FILEINFO_MIME_TYPE);

$fileType = $finfo->file($file['tmp_name']);

if ($fileType !== 'application/pdf') {

    uploadError("The selected file is not a valid PDF.");
}


/*
 * Check PDF signature
 */
$handle = fopen($file['tmp_name'], 'rb');

$signature = $handle ? fread($handle, 5) : '';

if ($handle) {
    fclose($handle);
}

if ($signature !== '%PDF-') {

    uploadError("The selected file is not a valid PDF.");
}


/*
 * Set upload directory
 */
$uploadDirectory = "../files/";


/*
 * Confirm upload directory exists
 */
if (!is_dir($uploadDirectory)) {

    uploadError("Upload directory does not exist.");
}


/*
 * Generate a unique file name
 * to prevent duplicate names and unsafe paths
 */
try {

    $newFileName = bin2hex(random_bytes(16)) . ".pdf";
} catch (Exception $e) {

    uploadError("Could not generate a file name.");
}


/*
 * Set full destination path
 */
$destination = $uploadDirectory . $newFileName;


/*
 * Relative path stored in database
 */
$filePath = "files/" . $newFileName;


/*
 * Move PDF to files folder
 */
if (!move_uploaded_file($file['tmp_name'], $destination)) {

    uploadError("Could not save the uploaded file.");
}


/*
 * INSERT file name and path into database
 */
$sql = "INSERT INTO files (file_name, file_path)
        VALUES (:file_name, :file_path)";


/*
 * Bind user-supplied values
 */
$bindings = [

    [':file_name', $fileName, 'str'],

    [':file_path', $filePath, 'str']

];


/*
 * Execute INSERT using instructor's PdoMethods class
 */
try {

    $pdo = new PdoMethods();

    $result = $pdo->otherBinded($sql, $bindings);
} catch (Exception $e) {

    error_log($e->getMessage());

    $result = 'error';
}


/*
 * Check database result
 */
if ($result === 'noerror') {

    header("Location: ../index.php?success=1");
    exit;
} else {

    // Remove uploaded file if database INSERT failed
    unlink($destination);

    uploadError("Could not save file information to database.");
}
