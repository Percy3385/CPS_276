<?php
$numbers = range(1, 50);
$evenNumbers = "Even Numbers: ";
foreach ($numbers as $number) {
    if ($number % 2 == 0) {
        $evenNumbers .= $number . " - ";
    }
}
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
function createTable($rows, $columns)
{
    $table = '<table class="table table-bordered">';
    for ($i = 1; $i <= $rows; $i++) {
        $table .= "<tr>";
        for ($j = 1; $j <= $columns; $j++) {
            $table .= "<td>Row $i, Col $j</td>";
        }
        $table .= "</tr>";
    }
    $table .= "</table>";
    return $table;
}
$table = createTable(8, 6);
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assignment 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <?php echo $evenNumbers; ?>
        <?php echo $form; ?>
        <?php echo $table; ?>
    </div>
</body>

</html>