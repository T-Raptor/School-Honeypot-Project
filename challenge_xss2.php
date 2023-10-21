<!DOCTYPE html>
<html>
<head>
    <title>XSS Challenge</title>
</head>
<body>
    <h1> Challenge 5</h1>
    <p>
        Please enter your name:
        <input type="text" name="name" id="name">
        <button onclick="showGreeting()">Submit</button>
    </p>

    <div id="greeting"></div>

    <script>
        function showGreeting() {
            var name = document.getElementById("name").value;
            document.getElementById("greeting").innerHTML = "Hello, " + name;
        }
    </script>
</body>
</html>
