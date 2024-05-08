<?php
session_start();
include '../db_connection.php';
$userId = $_SESSION['user']['id']; // Get userId from session
$clubId = $_POST['clubId'];
$sql = "INSERT IGNORE INTO user_clubs (user_id, club_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $clubId);
if ($stmt->execute() !== TRUE) {
    die("Error: " . $stmt->error);
} else {
    $clubName = $_POST['clubName'];
    header("Location: club-details.php?name=" . urlencode($clubName)); // Redirect back to the club details page
}
?>