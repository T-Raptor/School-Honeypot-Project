<!DOCTYPE html>
<html>
<head>
    <title>XSS Challenge</title>
    <link rel="stylesheet" type="text/css" href="../css/challenges.css">
</head>
<body>
    <h1>XSS Challenge</h1>
    <p>
        Welcome! This page allows you to post comments. Try to inject a script that will execute when the comment is displayed.
    </p>

    <h2>Post a comment:</h2>
    <form action="#" method="post">
        <textarea name="comment" rows="4" cols="50"></textarea><br>
        <button type="submit">Post Comment</button>
    </form>
    <a href="../challenges.php" class="button-style">Go back to Challenges</a>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<p><strong>Comment:</strong> " . htmlspecialchars($_POST['comment']) . "</p>";
    }
    ?>
</body>
</html>
