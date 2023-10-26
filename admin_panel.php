<?php
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header("Location: login.html");
    exit();
}

require_once("config.php");

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
    <style>
        table {
            font-family: "Roboto Mono", monospace;
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: center;
        }

        th, td {
            border: 1px solid gray;
            padding: 8px;
        }

        th {
            background-color: darkred;
            color: white;
        }

        a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            padding: 3px;
            border: 5px solid darkred;
        }

        .actions_column {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Actions</th>
                </tr>";

        // Output data of each row
        $firstRow = true;
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["user_id"].
                    "</td><td>".$row["name"].
                    "</td><td>".$row["email"]."</td>
                    <td><img src='".$row["avatar"]."' width='50' height='50'></td>
                    <td class='actions_column'>";
            
            if (!$firstRow) {
                echo "<a href='edit_user.php?id=".$row["user_id"]."'>Edit</a> |
                      <a href='delete_user.php?id=".$row["user_id"]."'>Delete</a>";
            }
            
            echo "</td>
                </tr>";
            
            $firstRow = false;
        }

        echo "</table>";
    } else {
        echo "No registered users found";
    }

    $conn->close();
    ?>
</body>
</html>
