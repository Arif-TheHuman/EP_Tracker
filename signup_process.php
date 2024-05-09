<?php
session_start();
include 'db_connection.php';
$sql = "INSERT INTO users (username, password, email, phone_number) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $_POST['username'], $_POST['password'], $_POST['email'], $_POST['phone_number']);
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