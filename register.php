<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "your_db_server";
    $username = "your_db_username";
    $password = "your_db_password";
    $dbname = "your_db_name";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
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
        $_SESSION['user_id'] = $conn->insert_id;
        header("Location: challenges.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
