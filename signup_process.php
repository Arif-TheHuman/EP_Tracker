<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ECPS";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $_POST['username'], $_POST['password']);
$stmt->execute();
if ($stmt->affected_rows > 0) {
  $_SESSION['message'] = "Account created successfully";
  header('Location: login.php');
} else {
  echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>