<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html"); // Redirect to login page if not logged in
    exit();
}

$allowed_user_id = 1; // Allow access only for user with ID 1 (for example)

if ($_COOKIE['userid'] != $allowed_user_id) {
    echo "You are not authorized to view this page.";
    echo "<br><a href='challenges.php'>Go back to Challenges</a>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Restricted Page</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Restricted Page</h1>
        <p>You are allowed to view this restricted page because you have the authorized user ID: <?php echo $allowed_user_id ?></p>
        <p>This is a restricted area for authorized users only.</p>
        <p><a href="challenges.php">Go back to Challenges</a></p>
    </div>
</body>
</html>
