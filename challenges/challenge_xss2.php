<!DOCTYPE html>
<html>
<head>
    <title>XSS Challenge</title>
    <link rel="stylesheet" type="text/css" href="../css/challenges.css">
</head>
<body>
    <h1>Challenge 5</h1>
    <p>
        Please enter your name:
        <input type="text" name="name" id="name">
        <button onclick="showGreeting()">Submit</button>
    </p>

    <div id="greeting" style="height: 3.3rem;"></div>

    <a href="../challenges.php" class="button-style">Go back to Challenges</a>

    <script>
        function showGreeting() {
            var name = document.getElementById("name").value;
            document.getElementById("greeting").innerHTML = "Hello, " + name;
        }
    </script>
</body>
</html>
