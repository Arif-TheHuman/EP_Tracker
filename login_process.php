<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, role FROM users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $_POST['username'], $_POST['password']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  // login success
  $row = $result->fetch_assoc();
  session_start();
  $_SESSION['username'] = $_POST['username'];
  $_SESSION['role'] = $row['role'];
  if ($_SESSION['role'] == 'admin') {
    header('Location: admin/dashboard.php');
  } else {
    header('Location: index.php');
  }
} else {
  // login failed
  echo "Invalid username or password";
}
$stmt->close();
$conn->close();
?>