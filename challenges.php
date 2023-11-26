<?php
session_set_cookie_params([
    'secure' => true,     // Set the cookie to be sent over secure (HTTPS) connections only
    'httponly' => true,   // Make the cookie accessible only through the HTTP protocol
]);

session_start();

require_once "util/config.php";
require_once "util/challenge_check_config.php";
require_once "util/login_check.php";

checkIfLoggedIn();

$conn = new mysqli($servername, $chalcheck_username, $chalcheck_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$avatar = ($_SESSION['avatar'] != null) ? $_SESSION['avatar'] : 'https://shorturl.at/fkJM9';

// Assuming you have a 'name' key in the $_SESSION array
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'User';

// Check if logged in user is the admin
$is_admin = isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1;

$solvedChallengesCount = 0;

// Function to check if a challenge is solved by the user
function isChallengeSolved($conn, $user_id, $challenge_id) {
    $count = null;

    $sql = "SELECT COUNT(*) FROM solved_challenges WHERE user_id = ? AND challenge_id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $challenge_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count > 0;
}

$challenges = [
    ['id' => 1, 'name' => 'SQLi'],
    ['id' => 2, 'name' => 'XSS'],
    ['id' => 3, 'name' => 'Access_Control'],
    ['id' => 4, 'name' => 'CSRF'],
    ['id' => 5, 'name' => 'XSS2']
];

$solvedChallengesCount = 0;
foreach ($challenges as $challenge) {
    if (isChallengeSolved($conn, $_SESSION['user_id'], $challenge['id'])) {
        $solvedChallengesCount++;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Challenges</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style>
        .container>div {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        img {
            width: 5rem;
            height: 5rem;
            border-radius: 30%;
        }

        .challenge-item {
            background-color: lightgray;
            padding: 0.5rem;
            border-radius: 0.5rem;
            margin-bottom: 0.4rem;
            color: black;
        }

        .challenge-item:hover {
            background-color: darkgray;
        }
        
        .solved-challenge {
            background-color: green;
            color: white;
        }

        .solved-challenge:hover {
            background-color: darkgreen;
        }

        #challenge-title {
            display: flex;
        }

        #challenge-title * {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div>
            <div>
                <h2>Challenges</h2>
                <p>Welcome, <b><?php echo $user_name; ?></b>!</p>
            </div>
            <img src="<?php echo $avatar ?>" alt="avatar">
        </div>

        <div id="challenge-title">
            <h3>Available Challenges</h3>
            <p>Challenges solved: <b>
                <?php echo htmlspecialchars($solvedChallengesCount, ENT_QUOTES, 'UTF-8') .
                "/" .
                htmlspecialchars(count($challenges), ENT_QUOTES, 'UTF-8'); ?>
                </b>
            </p>
        </div>
        <ol>
            <?php
            foreach ($challenges as $challenge) {
                $challenge_id = $challenge['id'];
                $challenge_name = $challenge['name'];
                $isSolved = isChallengeSolved($conn, $user_id, $challenge_id);
                $class = $isSolved ? 'solved-challenge' : '';
                ?>
            
                <a href="challenges/challenge_<?php echo $challenge_name; ?>.php">
                    <li class="challenge-item <?php echo $class; ?>">
                        CHALLENGE <?php echo $challenge_id; ?>
                    </li>
                </a>
            
            <?php
            }
            ?>
        </ol>

        <?php if ($is_admin): ?>
            <button style="background-color: darkred;">
                <a href="admin_panel.php" style="color: white;">Admin Panel</a>
            </button>
        <?php endif; ?>

        <p><a class="button-style" href="logout.php">Logout</a></p>
    </div>
</body>
</html>
