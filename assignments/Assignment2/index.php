<?php
// Create an array with numbers 1 through 50
$numbers = range(1, 50);

// Start the string that will display the even numbers
$evenNumbers = "Even Numbers: ";

//2. Loop through each number in the array
foreach ($numbers as $number) {

    // Check if the number is even
    if ($number % 2 == 0) {

        // Add the even number to the string
        $evenNumbers .= $number . " - ";
    }
}

// Store the Bootstrap form HTML inside a PHP variable
// 3. Heredoc - a PHP string, containing several lines of HTML
$form = <<<HTML
<div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" placeholder="name@example.com">
</div>
<div class="mb-3">
    <label for="textarea" class="form-label">Example textarea</label>
    <textarea class="form-control" id="textarea" rows="3"></textarea>
</div>

HTML;
//5. Function used to create the table
function createTable($rows, $columns)
{

    // Start the Bootstrap table
    $table = '<table class="table table-bordered">';

    //4a. Loop through the rows (Outer Loop)
    for ($i = 1; $i <= $rows; $i++) {

        //4a. Loop through the columns (Inner Loop)
        $table .= "<tr>";
        //4a. Every time the outer loop runs, its creates a new row using <tr>
        for ($j = 1; $j <= $columns; $j++) {

            // Add a table cell with the row and column number
            $table .= "<td>Row $i, Col $j</td>";
            //4a. For every row, the inner loop creates each table cell using <td>
            //4b. the ".=" operator is used to keep adding HTML to the existing $table variable
        }

        // Close the table row
        $table .= "</tr>";
    }
    $table .= "</table>";
    

    //5. Return the finished table
    return $table;
}

//5. Create an 8 row by 6 column table
$table = createTable(8, 6);
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assignment 2</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Bootstrap container for the page content -->
    <div class="container-fluid">

        <!-- Display the even numbers -->
        <?php echo $evenNumbers; ?>

        <!-- Display the form -->
        <?php echo $form; ?>

        <!-- Display the table -->
        <?php echo $table; ?>

    </div>
</body>

</html>