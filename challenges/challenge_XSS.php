<?php
    require_once "../util/login_check.php";
    checkIfLoggedIn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>XSS Example</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/css/challenges.css">
    <style>
        #queryResult {
            height: 8rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Search Engine</h2>
        <p>Search for something.</p>
        <hr>


        <form method="GET">
            <input type="text" name="query" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
        <div id="queryResult">
            <?php
            if (isset($_GET['query'])) {
                $query = $_GET['query'];
                echo "<p>Search results for '$query':</p>";
                echo "<ul>";
                // Vulnerable code: $query is echoed without proper escaping
                echo "<li>Result 1: $query</li>";
                echo "<li>Result 2: Some other result</li>";
                echo "</ul>";
            }
            ?>
        </div>

        <a href="/challenges.php" class="button-style" style="margin-top: 3rem;">Go back to Challenges</a>
    </div>
</body>
</html>

