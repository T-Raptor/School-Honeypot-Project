<?php
function saveSolvedChallenge($challengeId) {
    require_once "../util/challenge_check_config.php";

    $conn = new mysqli($servername, $chalcheck_username, $chalcheck_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if a record already exists for the user and challenge
    $checkStmt = $conn->prepare("SELECT * FROM solved_challenges WHERE user_id = ? AND challenge_id = ?");
    $checkStmt->bind_param("ii", $_SESSION["user_id"], $challengeId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // A record already exists, so return early
        $checkStmt->close();
        return;
    }

    $checkStmt->close();

    $stmt = $conn->prepare("INSERT INTO solved_challenges (user_id, challenge_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $_SESSION["user_id"], $challengeId);
    $stmt->execute();
    $stmt->close();
}
