<?php
require_once "../util/save_solved_challenge.php";
require_once "../util/login_check.php";

checkIfLoggedIn();

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/css/challenges.css">
    <style>
        #resultUser {
            min-height: 9rem;
        }

        #resultUser h4 {
            margin-bottom: 0rem;
        }

        #resultUser p+p {
            margin-top: 0.5rem;
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>User Profile</h1>
        <p>Enter a user ID to retrieve the user's profile information.</p>
        <hr>
        <form action="challenge_SQLi.php" method="get">
        <label for="id">Enter User ID:</label>
        <input type="text" id="id" name="id" placeholder="e.g., 1" required><br>
        <button type="submit">Retrieve User Info</button>
        </form>

        <div id="resultUser">
            <?php
            $userInput = $_GET['id'];

            if ($userInput !== null && $userInput !== '') {
                $sql = "SELECT * FROM sql_list WHERE user_id = '" . $userInput . "'";

                try {
                    $result = $conn->query($sql);

                    // Display the results
                    if ($result && $result->num_rows > 0) {
                        if ($result->num_rows > 1) {
                            echo '<p class="challenge-solved">Congrats on solving this challenge!</p>';
                            saveSolvedChallenge(1);
                        }

                        while ($row = $result->fetch_assoc()) {
                            echo "<h4>User " . $row['user_id'] . "</h4>
                                    <p><b>Username:</b> " . $row['username'] . "</p>
                                    <p><b>Email:</b> " . $row['email'] . "</p>";
                        }
                    } else {
                        echo "<p>User ID not found.</p>";
                    }
                } catch (mysqli_sql_exception $e) {
                    echo "<p>Invalid input.</p>";
                }
            }
            // Close the connection
            mysqli_close($conn);
            ?>
        </div>
        <a href="/challenges.php" class="button-style" style="margin-top: 3rem;">Go back to Challenges</a>
    </div>
</body>

</html>
