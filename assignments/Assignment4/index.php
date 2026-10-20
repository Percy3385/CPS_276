<?php
/*
Question 1:
require_once loads Calculator.php so we can use the class.
It also makes sure the file is only loaded one time.
require would load it again if called again.
include gives a warning if the file is missing,
while require stops the script with an error.
*/
require_once "calculator.php";
/*
 Question 3:
Calculator is the class (the blueprint).
$Calculator is the object made from that class.
We create the object so we can call its calc() method.
*/
$Calculator = new Calculator();
// This variable will hold all the calculation results.
$result = "";
// Test multiplication
$result .= $Calculator->calc("*", 10, 2);
$result .= $Calculator->calc("*", 4.56, 2);
// Test division
$result .= $Calculator->calc("/", 10, 2);
$result .= $Calculator->calc("/", 10, 3);
$result .= $Calculator->calc("/", 10, 0);
$result .= $Calculator->calc("/", 0, 10);
// Test subtraction
$result .= $Calculator->calc("-", 10, 2);
$result .= $Calculator->calc("-", 10, 20);
// Test addition
$result .= $Calculator->calc("+", 10.5, 2);
$result .= $Calculator->calc("+", 10.5, 0);
// Test missing and incorrect arguments
$result .= $Calculator->calc("*", 10);
$result .= $Calculator->calc("+", "a", 10);
$result .= $Calculator->calc("+", 10, "a");
$result .= $Calculator->calc(10);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Calculator Output</title>
</head>

<body>
    <!-- Question 5:
    index.php handles the HTML and displays the results.
    Calculator.php handles the actual math.
    Keeping them separate makes the code easier to read,
    fix, and update without changing everything.
    -->
    <h1>Calculator Output</h1>
    <main>
        <?php echo $result ?>
    </main>
</body>

</html>