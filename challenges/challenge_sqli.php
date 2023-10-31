<!DOCTYPE html>
<html>
<head>
    <title>SQL Injection Challenge</title>
    <link rel="stylesheet" type="text/css" href="/css/challenges.css">
</head>
<body>
    <h1>SQL Injection Challenge</h1>
    <p>
        Try to perform a SQL injection attack to retrieve sensitive information from the database. Input the user ID to fetch their information.
    </p>
    <form action="challenge_sqli.php" method="get">
        <label for="id">Enter User ID:</label>
        <input type="text" id="id" name="id" placeholder="e.g., 1" required><br>
        <button type="submit">Retrieve User Info</button>
    </form>

    <p style='height: 2rem;'>
    <?php
    if (isset($_GET['id'])) {
        require_once("../util/config.php");

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $id = $_GET['id'];

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["user_id"] . ", Name: " . $row["name"] . ", Email: " . $row["email"];
            }
        } else {
            echo "No results";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
    </p>

    <a href="/challenges.php" class="button-style" style="margin-top: 3rem;">Go back to Challenges</a>
</body>
</html>
