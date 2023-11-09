<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>

<form action="challenge_sqli.php" method="get">
    <label for="id">Enter User ID:</label>
    <input type="text" id="id" name="id" placeholder="e.g., 1" required><br>
    <button type="submit">Retrieve User Info</button>
</form>

<?php
// Database connection details
$servername = "localhost";
$username = "sql_user";
$password = "tryandsee";
$dbname = "sql_database";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$userInput = $_GET['user_input'];


$sql = "SELECT * FROM sql_list WHERE username = '" . $userInput . "'";

$result = mysqli_query($conn, $sql);

// Display the results
while ($row = mysqli_fetch_assoc($result)) {
    echo "<h2>User Profile</h2>";
    echo "<p>Username: " . $row['username'] . "</p>";
    echo "<p>Email: " . $row['email'] . "</p>";
}

// Close the connection
mysqli_close($conn);
?>
<a href="/challenges.php" class="button-style" style="margin-top: 3rem;">Go back to Challenges</a>
</body>
</html>
