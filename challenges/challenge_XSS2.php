<?php
require_once "../util/login_check.php";
checkIfLoggedIn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Vulnerable XSS Example</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/css/challenges.css">
</head>

<body>
    <div class="container">
        <h2>Broken input</h2>
        <p>WIP 👷‍♂️</p>
        <hr>

        <?php
        // Check if the "input" key is set in the $_GET array
        if (isset($_GET['input'])) {
            // Get user input from the query parameter
            $userInput = $_GET['input'];

            // Display the user input without proper escaping (VULNERABLE)
            echo "<p>User Input: $userInput</p>";
        } else {
            echo "<p>No user input provided.</p>";
        }
        ?>
        <a href="/challenges.php" class="button-style">Go back to Challenges</a>

    </div>
</body>

</html>
