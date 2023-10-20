<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Assuming you have a 'name' key in the $_SESSION array
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'User';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Challenges</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Challenges</h1>
        <p>Welcome, <?php echo $user_name; ?>!</p>

        <h2>Available Challenges</h2>
        <ol>
            <li><a href="challenge_sqli.php">SQL Injection Challenge</a></li>
            <li><a href="challenge_xss.php">XSS Challenge</a></li>
            <li><a href="challenge_access_control.php">Broken Access Control Challenge</a></li>
        </ol>

        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
