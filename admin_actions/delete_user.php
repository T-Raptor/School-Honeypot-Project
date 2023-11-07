<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: logout.php");
    exit();
}

require_once("../util/admin_config.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
$stmt->bind_param("i", $_GET['id']);

if ($stmt->execute() === TRUE) {
    echo "<script type='text/javascript'>
            alert('User " . $_GET["id"] . " deleted successfully');
            location='../admin_panel.php';
        </script>";
} else {
    echo "<script><alert>Error deleting user: " . $conn->error . "</alert></script>";
    header("Location: ../admin_panel.php");
}

$stmt->close();
?>