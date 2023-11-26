<?php
session_set_cookie_params([
    'secure' => true,     // Set the cookie to be sent over secure (HTTPS) connections only
    'httponly' => true,   // Make the cookie accessible only through the HTTP protocol
]);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "util/config.php";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user input
    $name = $conn->real_escape_string(strip_tags($_POST['name']));
    $email = $conn->real_escape_string(strip_tags($_POST['email']));

    // Use prepared statement to check if email already exists
    $stmt = $conn->prepare("SELECT * FROM users_list WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $stmt->close();
        $conn->close();
        echo "<script>
                alert('Please choose a different email!');
                window.location.replace('https://honeypot/register.html');
            </script>";
        exit();
    }

    $password = $_POST['password'];

    // Use password_hash() to securely hash passwords
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Save avatar url
    $avatar = null;
    if (isset($_POST['img_url'])) {
        $avatar = $conn->real_escape_string($_POST['img_url']);
    }

    // Use prepared statement to insert user data
    $stmt = $conn->prepare("INSERT INTO users_list (name, email, password, avatar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $avatar);
    
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        setcookie('user_id', $_SESSION['user_id']);

        $_SESSION['name'] = ucwords(strtolower($name));
        $_SESSION['avatar'] = $avatar;

        $stmt->close();
        $conn->close();

        header("Location: challenges.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
