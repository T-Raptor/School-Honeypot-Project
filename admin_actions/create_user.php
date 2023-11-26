<?php
session_set_cookie_params([
    'secure' => true,     // Set the cookie to be sent over secure (HTTPS) connections only
    'httponly' => true,   // Make the cookie accessible only through the HTTP protocol
]);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "/util/admin_config.php";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);
    $password = $_POST['password'];

    // Hash the password for storage
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Upload avatar
    $avatar = null;
    if ($_FILES['avatar']['size'] > 0) {
        $target_dir = "avatars/";
        $avatar = $target_dir . basename($_FILES['avatar']['name']);
        move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar);
    }

    $sql = "INSERT INTO users_list (name, email, password, avatar)
        VALUES ('$name', '$email', '$hashed_password', '$avatar')";

    if ($conn->query($sql) === true) {
        // Refresh the page
        header("Location: /admin_panel.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
