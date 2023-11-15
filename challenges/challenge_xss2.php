<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vulnerable XSS Example</title>
</head>
<body>
 
<?php
// Check if the "input" key is set in the $_GET array
if (isset($_GET['input'])) {
    // Get user input from the query parameter
    $userInput = $_GET['input'];
 
    // Display the user input without proper escaping (VULNERABLE)
    echo "<p>User Input: $userInput</p>";
} else {
    echo "<p>No user input provided.</p>";
}
?>
  <a href="/challenges.php" class="button-style">Go back to Challenges</a>

    
</body>
</html>
