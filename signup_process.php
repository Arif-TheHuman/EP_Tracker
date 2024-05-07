<?php
session_start();
include 'db_connection.php';
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $_POST['username'], $_POST['password']);
$stmt->execute();
if ($stmt->affected_rows > 0) {
  $_SESSION['message'] = "Account created successfully";
  header('Location: ./home/index.php');
} else {
  echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>