<?php
session_set_cookie_params([
    'secure' => true,     // Set the cookie to be sent over secure (HTTPS) connections only
    'httponly' => true,   // Make the cookie accessible only through the HTTP protocol
]);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "util/config.php";

    $login_email = $_POST['login_email'];
    $login_password = $_POST['login_password'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statement to retrieve user data
    $stmt = $conn->prepare("SELECT user_id, name, password, avatar FROM users_list WHERE email = ?");
    $stmt->bind_param("s", $login_email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $name, $hashed_password, $avatar);
        $stmt->fetch();

        // Verify the password
        if (password_verify($login_password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['name'] = ucwords(strtolower($name));
            $_SESSION['avatar'] = $avatar;
            setcookie('user_id', $_SESSION['user_id']);
            header("Location: challenges.php");
            exit();
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "User not found. Please register first.";
    }

    $stmt->close();
    $conn->close();
}
