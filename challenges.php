<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$avatar = isset($_SESSION['avatar']) ? $_SESSION['avatar'] : 'https://shorturl.at/fkJM9';

// Assuming you have a 'name' key in the $_SESSION array
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'User';

// Check if logged in user is the admin
$is_admin = isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Challenges</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <h1>Challenges</h1>
                <p>Welcome, <?php echo $user_name; ?>!</p>
            </div>
            <img src="<?php echo $avatar ?>" alt="avatar" style="width: 5rem; height: 5rem; border-radius: 30%;">
        </div>

        <h2>Available Challenges</h2>
        <ol>
            <li><a href="challenges/challenge_sqli.php">CHALLENGE 1</a></li>
            <li><a href="challenges/challenge_xss.php">CHALLANGE 2</a></li>
            <li><a href="challenges/challenge_access_control.php">CHALLENGE 3</a></li>
            <li><a href="challenges/challenge_CSRF.php">CHALLENGE 4</a></li>
            <li><a href="challenges/challenge_xss2.php">CHALLENGE 5</a></li>
        </ol>

        <?php if ($is_admin): ?>
            <button style="background-color: darkred;"><a href="admin_panel.php" style="color: white;">Admin Panel</a></button>
        <?php endif; ?>

        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
