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
    // If the insert was successful, increment the current_members column of the club
    $sql = "UPDATE clubs SET current_members = current_members + 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clubId);
    if ($stmt->execute() !== TRUE) {
        die("Error updating record: " . $stmt->error);
    }

    $clubName = $_POST['clubName'];
    header("Location: club-details.php?name=" . urlencode($clubName)); // Redirect back to the club details page
}
?>