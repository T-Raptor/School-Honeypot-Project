<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("/util/config.php");

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

    $sql = "INSERT INTO users (name, email, password, avatar) VALUES ('$name', '$email', '$hashed_password', '$avatar')";

    if ($conn->query($sql) === TRUE) {
        # ? V
        $_SESSION['user_id'] = $conn->insert_id;
        setcookie('user_id',$_SESSION['user_id']);

        $_SESSION['name'] = ucwords(strtolower($name));

        header("Location: challenges.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
