<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "your_db_server";
    $username = "your_db_username";
    $password = "your_db_password";
    $dbname = "your_db_name";

    $login_email = $_POST['login_email'];
    $login_password = $_POST['login_password'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE email='$login_email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($login_password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: challenges.php");
            exit();
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "User not found. Please register first.";
    }

    $conn->close();
}
?>
