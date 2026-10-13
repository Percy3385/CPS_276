<?php
/*
Question 2:
$_SERVER["REQUEST_METHOD"] tells PHP how the page was requested.
If the value is "POST", that means the form was submitted using
method="post". This prevents the processing code from running when
someone simply opens the page normally.
*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the value of the button that was clicked.
    $action = $_POST["action"];
    // Get the current list of names from the textarea.
    $names = $_POST["names"];
    /*
Question 5:
Both submit buttons use the name "action".
The Add Name button sends:
        action = add
The Clear Names button sends:
        action = clear
    */
    if ($action == "clear") {
        // Clear the entire list.
        $names = "";
    } else if ($action == "add") {
        // Get the name entered by the user.
        $name = trim($_POST["name"]);
        // Only continue if the user entered a name.
        if ($name != "") {
            /*
Question 3:
explode() takes a string and separates it into an array.
For example:
"Scott Shaper" | becomes: ["Scott", "Shaper"]
            */
            $nameParts = explode(" ", $name);
            // First item in the array is the first name.
            $firstName = $nameParts[0];
            // Last item in the array is the last name.
            $lastName = $nameParts[count($nameParts) - 1];
            // Format the name as Last, First.
            $formattedName = $lastName . ", " . $firstName;
            // Add the new name to the existing list.
            if ($names != "") {
                $names = $names . "\n" . $formattedName;
            } else {
                $names = $formattedName;
            }
            /*
            Convert the entire textarea into an array.
Each line becomes one element in the array.
            */
            $nameArray = explode("\n", $names);
            // Sort the names alphabetically.
            sort($nameArray);
            /*
Question 4:
            implode() does the opposite of explode().
It takes the array of sorted names and joins the items
            back into one string.
"\n" places each name on a new line so the list
            displays correctly inside the textarea.
            */
            $names = implode("\n", $nameArray);
        }
    }
    /*
    Send the finished list back to index.php.
urlencode() makes the text safe to place inside the URL.
    */
    header("Location: index.php?names=" . urlencode($names));
    // Stop processNames.php after redirecting.
    exit();
}
