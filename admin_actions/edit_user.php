<?php
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: login.html");
    exit();
}

require_once("../util/admin_config.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    // Get user data
    $sql = "SELECT * FROM users_list WHERE user_id = " . $_GET['id'];
    $result = $conn->query($sql);
}
else {
    echo "No user ID specified";
}

// Update user data where user_id = $_GET['id']
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $sql = "UPDATE users_list SET name = '$name', email = '$email', password = '$hashed_password', avatar = '$avatar' WHERE user_id = " . $_POST['id'];

    if ($conn->query($sql) === TRUE) {
        header("Location: ../admin_panel.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Edit user</title>
    <style>
        table {
            width: 60%;
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
        }

        td, input {
            text-align: center;
            padding: 0.25rem;
        }

        input[readonly] {
            background-color: transparent;
            border: none;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <form id="editForm" action="edit_user.php" method="post" enctype="multipart/form-data">
                <tr>
                    <th>User ID</th>
                    <th><label for="name">Name</label></th>
                    <th><label for="email">Email</label></th>
                    <!--<th><label for="avatar">Avatar</label</th>-->
                    <th><label for="password">Password</label></th>
                </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            $firstRow = true;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td><input type='text' name='id' value='" . $_GET['id'] . "' readonly></td>
                        <td><input form='editForm' type='text' id='name' name='name' required value='" . $row["name"] . "'></td>
                        <td><input form='editForm' type='email' id='email' name='email' required value='" . $row["email"] . "'></td>
                        <!--<td><input form='editForm' type='file' id='avatar' name='avatar'></td>-->
                        <td><input form='editForm' type='password' id='password' name='password' required></td>
                    </tr>";
                $firstRow = false;
            }
        } else {
            echo "<tr><td colspan='4'>No users found</td></tr>";
        }
        ?>
        <tr>
            <td colspan="5"><button form="editForm" type="submit" style="margin-top: 1rem;">Submit changes</td>
        </tr>
            </form>
            <tr>
                <td colspan='100%' style='text-align: center; padding-top: 2rem; border: none;'>
                    <a href='../admin_panel.php' class="button-style">Go back to Admin Panel</a>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>