<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("util/config.php");
    
    $login_email = $_POST['login_email'];
    $login_password = $_POST['login_password'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users_list WHERE email='$login_email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($login_password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name'] = ucwords(strtolower($row['name']));
            setcookie('user_id', $_SESSION['user_id']);
            header("Location: challenges.php");
            exit();
        } else {
            echo "Incorrect password. Please try again.";
            echo $row;
        }
    } else {
        echo "User not found. Please register first.";
    }

    $conn->close();
}

?>
