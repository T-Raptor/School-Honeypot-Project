<?php
session_set_cookie_params([
    'secure' => true,     // Set the cookie to be sent over secure (HTTPS) connections only
    'httponly' => true,   // Make the cookie accessible only through the HTTP protocol
]);

session_start();

require_once "../util/login_check.php";

checkIfLoggedIn();

$allowed_user_id = 1; // Allow access only for user with ID 1 (for example)

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Restricted Page</title>
    <link rel="stylesheet" type="text/css" href="/css/challenges.css">
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
</head>

<body>
    <div class="container">
        <h2>Super secure access</h2>
        <p>Only admins may access this page.</p>
        <hr>

        <?php
        if ($_COOKIE['user_id'] != $allowed_user_id) {
            echo "
                <h3>You are not authorized to view this page.</h3>
                <a href='/challenges.php' class='button-style'>Go back to Challenges</a>";
            exit();
        } else {
        ?>
            <h2>Welcome to the Restricted Page</h2>
            <p>You are allowed to view this restricted page because you have the authorized user ID:
                <b><?php echo $allowed_user_id ?></b>
            </p>
            <p>This is a restricted area for authorized users only.</p>
            <a href="/challenges.php" class="button-style">Go back to Challenges</a>
        <?php
        }
        ?>
    </div>
</body>

</html>
