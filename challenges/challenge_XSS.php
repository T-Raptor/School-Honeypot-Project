<?php
require_once "../util/login_check.php";
require_once "../util/save_solved_challenge.php";

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
            min-height: 8rem;
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
                
                $pattern = '/<(script|iframe|img|body|input|link|div|table|style|svg|marquee|object)[^>]*+>/i';
                if (preg_match($pattern, $query)) {
                    echo '<p class="challenge-solved">Congrats on solving this challenge!</p>';
                    saveSolvedChallenge(2);
                }
                echo "<p>Search results for '$query':</p>";
                echo "<ul>";
                echo "<li>Result 1: $query</li>";
                echo "<li>Result 2: " . htmlspecialchars($query) . "</li>";
                echo "</ul>";
            }
            ?>
        </div>

        <a href="/challenges.php" class="button-style" style="margin-top: 3rem;">Go back to Challenges</a>
    </div>
</body>

</html>
