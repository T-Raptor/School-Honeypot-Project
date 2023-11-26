<?php
session_set_cookie_params([
    'secure' => true,     // Set the cookie to be sent over secure (HTTPS) connections only
    'httponly' => true,   // Make the cookie accessible only through the HTTP protocol
]);

session_start();

require_once "../util/login_check.php";
require_once "../util/save_solved_challenge.php";

checkIfLoggedIn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>CSRF Attack Page</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/css/challenges.css">
</head>

<body>
    <div class="container">
        <h2>Money transfer v10</h2>
        <p>Transfer your money with our secure service.</p>
        <hr>

        <form action="challenge_CSRF.php" method="post">
            <input type="hidden" name="action" value="transfer">
            <input type="hidden" name="amount" value="20">
            <button type="submit">Transfer &euro; 20</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['action'] === 'transfer') {
                if ($_POST['amount'] != 20) {
                    echo '<p class="challenge-solved">Congrats on solving this challenge!</p>';
                    saveSolvedChallenge(4);
                }

                echo "Transfer initiated. Please wait for confirmation.";
            } else {
                echo "Invalid action.";
            }
        } else {
            echo "You are not logged in.";
        }
        ?>
        <br><br>
        <a href="/challenges.php" class="button-style">Go back to Challenges</a>
    </div>
</body>

</html>
