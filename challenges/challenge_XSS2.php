<?php
require_once "../util/login_check.php";
require_once "../util/save_solved_challenge.php";

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
        if (isset($_GET['input'])) {
            // Get user input from the query parameter
            $userInput = $_GET['input'];

            // Check if the user input contains any HTML tags
            $pattern = '/<(script|iframe|img|body|input|link|div|table|style|svg|marquee|object)[^>]*+>/i';
            if (preg_match($pattern, $userInput)) {
                echo '<p class="challenge-solved">Congrats on solving this challenge!</p>';
                saveSolvedChallenge(5);
            }

            // Display the user input without proper escaping (VULNERABLE)
            echo "<p>User Input: $userInput</p>";
        } else {
            echo "<p>No input provided.</p>";
        }
        ?>
        <a href="/challenges.php" class="button-style">Go back to Challenges</a>

    </div>
</body>

</html>
