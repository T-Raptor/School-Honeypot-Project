<!DOCTYPE html>
<html lang="en">
<head>
    <title>CSRF Attack Page</title>
    <link rel="stylesheet" type="text/css" href="/css/challenges.css">
</head>
<body>
    <h1>CSRF Attack Page</h1>

<form action="challenge_CSRF.php" method="post">
        <input type="hidden" name="action" value="transfer">
        <input type="hidden" name="amount" value="9999">
        <button type="submit">Transfer $9999</button>
    </form>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in (you can implement your authentication logic here)
    if (isset($_SESSION['user'])) {
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
<br><br><br>
<a href="/challenges.php" class="button-style">Go back to Challenges</a>
</body>
</html>
