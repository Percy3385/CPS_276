
<?php
require_once __DIR__ . '/Pdo_methods.php';

class Date_time
{
    private $pdo;

    // Constructor runs when the object is created
    public function __construct()
    {
        // Q4: Time zones matter because the same clock time
        // can represent different moments in different places.
        // We use Michigan time for saving and displaying notes.
        date_default_timezone_set('America/Detroit');

        // Create an object from our existing PDO class
        $this->pdo = new PdoMethods();
    }

    // Check which form was submitted
    public function checkSubmit()
    {
        // Q2: Keeping the date work in one class prevents
        // us from repeating the same code on multiple pages.

        // If the page was just opened, do nothing
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return '';
        }

        // Check if Add Note was clicked
        if (isset($_POST['addNote'])) {
            return $this->addNote();
        }

        // Check if Get Notes was clicked
        if (isset($_POST['getNotes'])) {
            return $this->displayNotes();
        }

        return '';
    }

    // Add a note to the database
    private function addNote()
    {
        // Get the information entered by the user
        $date = trim($_POST['dateTime'] ?? '');
        $note = trim($_POST['note'] ?? '');

        // Make sure both fields were entered
        if ($date === '' || $note === '') {
            return $this->message(
                'You must enter a date, time, and note.',
                'danger'
            );
        }

        // Convert the form date into a PHP DateTime object
        $dateTime = DateTimeImmutable::createFromFormat(
            '!Y-m-d\TH:i',
            $date
        );

        // Make sure the date is valid
        if (
            !$dateTime ||
            $dateTime->format('Y-m-d\TH:i') !== $date
        ) {

            return $this->message(
                'Enter a valid date and time.',
                'danger'
            );
        }

        // Q1: We store a timestamp instead of a date string.
        // A timestamp is a number, making it easier to compare,
        // sort, and search dates in the database.
        $timestamp = $dateTime->getTimestamp();

        // Create the SQL INSERT statement
        $sql = "INSERT INTO note (date_time, note)
                VALUES (:dateTime, :note)";

        // Bind values using our PdoMethods class
        // Each binding contains: parameter, value, data type
        $bindings = [
            [':dateTime', $timestamp, 'int'],
            [':note', $note, 'str']
        ];

        // Execute the INSERT query
        $result = $this->pdo->otherBinded(
            $sql,
            $bindings
        );

        // Check whether the INSERT was successful
        if ($result === 'noerror') {
            return $this->message(
                'Note added successfully.',
                'success'
            );
        }

        return $this->message(
            'Unable to add the note. Check the database setup.',
            'danger'
        );
    }

    // Retrieve notes within a selected date range
    private function displayNotes()
    {
        // Get beginning and ending dates from the form
        $begin = trim($_POST['begDate'] ?? '');
        $end = trim($_POST['endDate'] ?? '');

        $emptyMessage = 'No notes found for the date range selected';

        // Check that both dates were entered
        if ($begin === '' || $end === '') {
            return $this->message($emptyMessage, 'warning');
        }

        // Convert the dates into PHP DateTime objects
        $beginDate = DateTimeImmutable::createFromFormat(
            '!Y-m-d',
            $begin
        );

        $endDate = DateTimeImmutable::createFromFormat(
            '!Y-m-d',
            $end
        );

        // Check that both dates are valid
        if (
            !$beginDate || !$endDate ||
            $beginDate->format('Y-m-d') !== $begin ||
            $endDate->format('Y-m-d') !== $end
        ) {

            return $this->message($emptyMessage, 'warning');
        }

        // Q5: The beginning date cannot be after the ending date.
        // Otherwise, the selected range would not make sense.
        if ($beginDate > $endDate) {
            return $this->message($emptyMessage, 'warning');
        }

        // Q3: Convert the dates into timestamps so the
        // database can compare them.

        // Beginning date starts at 12:00 AM
        $startTimestamp = $beginDate->getTimestamp();

        // Ending date includes everything through 11:59:59 PM
        $endOfDay = $endDate->setTime(
            23,
            59,
            59
        )->getTimestamp();

        // SQL query to retrieve notes in the date range
        $sql = "SELECT date_time, note
                FROM note
                WHERE date_time BETWEEN :begDate AND :endDate
                ORDER BY date_time DESC";

        // Bind the beginning and ending timestamps
        $bindings = [
            [':begDate', $startTimestamp, 'int'],
            [':endDate', $endOfDay, 'int']
        ];

        // Run the SELECT query using our PdoMethods class
        $rows = $this->pdo->selectBinded(
            $sql,
            $bindings
        );

        // Check whether the database query failed
        if ($rows === 'error') {
            return $this->message(
                'Unable to retrieve notes. Check the database setup.',
                'danger'
            );
        }

        // Display a message if no notes were found
        if (empty($rows)) {
            return $this->message($emptyMessage, 'warning');
        }

        // Start building the Bootstrap table
        $html = '<table class="table table-striped table-bordered">';

        $html .= '<thead>
                    <tr>
                        <th>Date and Time</th>
                        <th>Note</th>
                    </tr>
                  </thead>';

        $html .= '<tbody>';

        // Loop through each note returned from the database
        foreach ($rows as $row) {

            // Convert the timestamp back into a readable date
            // Format: mm/dd/yyyy HH:MM AM/PM
            $date = date(
                'm/d/Y h:i A',
                (int) $row['date_time']
            );

            // Escape the values before displaying them
            $safeDate = $this->escape($date);
            $safeNote = nl2br($this->escape($row['note']));

            // Add the note to the table
            $html .= '<tr>';
            $html .= '<td>' . $safeDate . '</td>';
            $html .= '<td>' . $safeNote . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

        // Return the completed table to display_notes.php
        return $html;
    }

    // Create Bootstrap success or error messages
    private function message($text, $type)
    {
        return '<div class="alert alert-' . $type . '">' .
            $this->escape($text) .
            '</div>';
    }

    // Prevent HTML entered by users from running in the page
    private function escape($text)
    {
        return htmlspecialchars(
            (string) $text,
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        );
    }
}
