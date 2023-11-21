<?php
session_set_cookie_params([
    'secure' => true,     // Set the cookie to be sent over secure (HTTPS) connections only
    'httponly' => true,   // Make the cookie accessible only through the HTTP protocol
]);

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html"); // Redirect to login page if not logged in
    exit();
}

$allowed_user_id = 1; // Allow access only for user with ID 1 (for example)

if ($_COOKIE['user_id'] != $allowed_user_id) {
    echo "You are not authorized to view this page.";
    echo "<br><a href='/challenges.php'>Go back to Challenges</a>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Restricted Page</title>
    <link rel="stylesheet" type="text/css" href="/css/challenges.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Restricted Page</h1>
        <p>You are allowed to view this restricted page because you have the authorized user ID:
            <?php echo $allowed_user_id ?></p>
        <p>This is a restricted area for authorized users only.</p>
        <a href="/challenges.php" class="button-style">Go back to Challenges</a>
    </div>
</body>
</html>