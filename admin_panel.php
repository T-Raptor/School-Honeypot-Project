<?php
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: login.html");
    exit();
}

require_once("util/admin_config.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: center;
            padding-bottom: 0.5rem;
        }

        td {
            border: 1px solid gray;
            padding: 0.25rem 0.25rem 0.25rem 0.5rem;
        }

        .actions_column {
            text-align: center;
        }

        .align_content td {
            text-align: center;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Avatar</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                $firstRow = true;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row["user_id"] .
                        "</td><td>" . $row["name"] .
                        "</td><td>" . $row["email"] . "</td>
                        <td><img src='" . $row["avatar"] . "' width='50' height='50'></td>
                        <td class='actions_column'>";

                    if (!$firstRow) {
                        echo "<a href='/admin_actions/edit_user.php?id=" . $row["user_id"] . "' class='button-style'>Edit</a> |
                        <a href='/admin_actions/delete_user.php?id=" . $row["user_id"] . "' class='button-style'>Delete</a>";
                    }

                    echo "</td>
                    </tr>";

                    $firstRow = false;
                }
            } else {
                echo "<tr>
                    <td colspan='100%' style='text-align: center;'>No registered users found</td>
                </tr>";
            }

            $conn->close();
            ?>
            <tr>
                <td colspan="100%" style="text-align: center; padding-top: 1rem; padding-bottom: 0; border: none;"><h2>Create user:</h2></td>
            </tr>
            <form id="createForm" action="admin_actions/create_user.php" method="post" enctype="multipart/form-data">
                <tr>
                    <th><label for="name">Name</label></th>
                    <th colspan="2"><label for="email">Email</label></th>
                    <th><label for="avatar">Avatar</label</th>
                    <th><label for="password">Password</label></th>
                </tr>
                <tr class="align_content">
                    <td><input form="createForm" type="text" id="name" name="name" required></td>
                    <td colspan="2"><input form="createForm" type="email" id="email" name="email" required></td>
                    <td><input form="createForm" type="file" id="avatar" name="avatar"></td>
                    <td><input form="createForm" type="password" id="password" name="password" required></td>
                </tr>
                <tr>
                    <td colspan="100%" style="text-align: center; padding-top: 1rem; padding-bottom: 0; border: none;"><button form="createForm" type="submit">Register</button></td>
                </tr>
            </form>

            <tr>
                <td colspan='100%' style='text-align: center; padding-top: 2rem; border: none;'>
                    <a href='challenges.php' class="button-style">Go back to Challenges</a>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>