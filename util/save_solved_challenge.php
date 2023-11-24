<?php
function insertSolvedChallenge($userId, $challengeId) {
    require_once "util/challenge_check_config.php";

    $conn = new mysqli($servername, $chalcheck_username, $chalcheck_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO solved_challenges (user_id, challenge_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $challengeId);
    $stmt->execute();
    $stmt->close();
}
