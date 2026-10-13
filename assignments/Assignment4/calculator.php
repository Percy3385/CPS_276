<?php
// Question 3:
// A class is like a blueprint that tells PHP what a calculator can do.
// The object is the actual calculator we create using that blueprint.
class Calculator
{
    public function calc($operator = null, $num1 = null, $num2 = null)
    {
        // This message is used when the arguments are not correct.
        $error = "Cannot perform operation. You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.";
        // Question 4:
        // We check that the numbers are integers or floats because
        // we cannot do math with letters or other invalid values.
        // We also check that the operator is one of the four allowed operators.
        if (
            $operator != "+" && $operator != "-" &&
            $operator != "*" && $operator != "/"
        ) {
            return "<p>$error</p>";
        }
        if ((!is_int($num1) && !is_float($num1)) ||
            (!is_int($num2) && !is_float($num2))
        ) {
            return "<p>$error</p>";
        }
        // This switch decides which math operation to perform.
        switch ($operator) {
            case "+":
                $answer = $num1 + $num2;
                break;
            case "-":
                $answer = $num1 - $num2;
                break;
            case "*":
                $answer = $num1 * $num2;
                break;
            case "/":
                // Question 2:
                // Before dividing, we check if the second number is zero.
                // Dividing by zero would cause an error in PHP.
                // Instead, we return a message explaining the problem.
                if ($num2 == 0) {
                    $answer = "cannot divide a number by zero";
                } else {
                    $answer = $num1 / $num2;
                }
                break;
        }
        // Return the calculation inside its own paragraph.
        return "<p>The calculation is $num1 $operator $num2. The answer is $answer.</p>";
    }
}
