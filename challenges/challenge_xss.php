<!DOCTYPE html>
<html>
<head>
    <title>XSS Example</title>
<link rel="stylesheet" type="text/css" href="/css/challenges.css">
</head>
<body>
    <h1>Search Engine</h1>
    <form method="GET">
        <input type="text" name="query" placeholder="Search...">
        <input type="submit" value="Search">
    </form>
    <div>
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
</body>
</html>

