<?php
class Directories
{
    public function createDirectory($folderName, $fileContent)
    {
        // Question 2:
        // The folder name and file content come from the form
        // in index.php. We check the folder name to make sure
        // it only contains letters and numbers.
        // This helps prevent invalid folder names.
        if (!ctype_alnum($folderName)) {
            return "Folder names must contain letters and numbers only.";
        }
        // This is where the new folder will be created.
        // __DIR__ gives us the location of this PHP file.
        // ../ moves up one folder into assignment5.
        $directory = __DIR__ . "/../directories/" . $folderName;
        // Question 1:
        // Creating a directory is different from creating a file.
        // mkdir() creates a folder, while fopen() creates or
        // opens a file.
        //
        // We use file_exists() before mkdir() because we don't
        // want to try creating a folder that already exists.
        // It also keeps us from accidentally changing old work.
        if (file_exists($directory)) {
            return "A directory already exists with that name.";
        }
        // Question 4:
        // mkdir() creates the new directory.
        // 0755 gives the owner permission to read, write,
        // and enter the directory. Other users can read
        // and enter it, but cannot write to it.
        //
        // 0777 allows everyone to read, write, and enter
        // the folder. That is less secure, so we use 0755.
        if (!mkdir($directory, 0755)) {
            return "Could not create directory.";
        }
        // Question 1:
        // fopen() opens or creates readme.txt.
        // The "w" means write mode.
        // If the file does not exist, PHP creates it.
        $file = fopen($directory . "/readme.txt", "w");
        if ($file == false) {
            return "Could not create file.";
        }
        // fwrite() puts the text from the form into the file.
        $written = fwrite($file, $fileContent);
        // Question 3:
        // fclose() closes the file after we finish writing.
        // Leaving files open can waste system resources
        // and may cause problems with buffered data or
        // opening other files later.
        fclose($file);
        if ($written === false || $written != strlen($fileContent)) {
            return "Could not write to file.";
        }
        // Question 5:
        // Keeping these operations inside a class makes
        // the program easier to organize and maintain.
        // If we need to change how folders or files are
        // created, we only have to change this class.
        $link = "directories/" . $folderName . "/readme.txt";
        return "File and directory were created.
                <p><a href='$link'>Path where file is located</a></p>";
    }
}
