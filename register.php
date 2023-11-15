<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("util/config.php");

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = strip_tags($_POST['name']);

    $email = strip_tags($_POST['email']);
    // Alert if email already exists
    $sql = "SELECT * FROM users_list WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<script>
                alert('Please choose a different email!');
                window.location.replace('https://honeypot/register.html');
            </script>";
        exit();
    }

    $password = $_POST['password'];

    // Hash the password for storage
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Save avatar url
    $avatar = null;
    if (isset($_POST['img_url'])) {
        $avatar = $_POST['img_url'];
    }

    $sql = "INSERT INTO users_list (name, email, password, avatar) VALUES ('$name', '$email', '$hashed_password', '$avatar')";

    if ($conn->query($sql) === TRUE) {
        # ? V
        $_SESSION['user_id'] = $conn->insert_id;
        setcookie('user_id',$_SESSION['user_id']);

        $_SESSION['name'] = ucwords(strtolower($name));
        $_SESSION['avatar'] = $avatar;

        header("Location: challenges.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
