<?php
session_set_cookie_params([
    'secure' => true,     // Set the cookie to be sent over secure (HTTPS) connections only
    'httponly' => true,   // Make the cookie accessible only through the HTTP protocol
]);

session_start();

require_once "../util/login_check.php";

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
            <input type="hidden" name="amount" value="9999">
            <button type="submit">Transfer $9999</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the user is logged in (you can implement your authentication logic here)
            if (isset($_SESSION['user_id'])) {
                if ($_POST['action'] === 'transfer') {
                    // You should validate and sanitize user input, verify authorization, etc.
                    // For this example, we will just simulate a response
                    echo "Transfer initiated. Please wait for confirmation.";
                } else {
                    echo "Invalid action.";
                }
            } else {
                echo "You are not logged in.";
            }
        } else {
            echo "Invalid request method.";
        }
        ?>
        <br><br>
        <a href="/challenges.php" class="button-style">Go back to Challenges</a>
    </div>
</body>

</html>