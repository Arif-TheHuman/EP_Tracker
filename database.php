<?php
$port = 3306;
$dbName = 'ECPS';
$servername = "localhost";
$username = "root";
$password = "";
$adminUsername = "admin";
$adminPassword = "admin";
$adminRole = "admin";
// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}
// Select the database
if (!$conn->select_db($dbName)) {
    die("Error selecting database: " . $conn->error);
}
// Create users table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(30) NOT NULL,
password VARCHAR(30) NOT NULL
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}
// Create clubs table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS clubs (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  image VARCHAR(255) NOT NULL,
  type ENUM('indoor', 'outdoor') NOT NULL
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'users' AND COLUMN_NAME = 'role'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    // The 'role' column doesn't exist, so add it
    $sql = "ALTER TABLE users ADD COLUMN role ENUM('user', 'admin') NOT NULL DEFAULT 'user'";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding column: " . $conn->error;
    }
}
$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $adminUsername, $adminPassword, $adminRole);
if ($stmt->execute() !== TRUE) {
    echo "Error creating admin user: " . $conn->error;
}

// Create clubs table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS clubs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    type ENUM('indoor', 'outdoor') NOT NULL,
    current_members INT(6) NOT NULL DEFAULT 0,
    quota INT(6) NOT NULL DEFAULT 0,
    img1 VARCHAR(255) NOT NULL,
    img2 VARCHAR(255) NOT NULL,
    img3 VARCHAR(255) NOT NULL
  )";
  if ($conn->query($sql) !== TRUE) {
      echo "Error creating table: " . $conn->error;
  }

$stmt->close();
$conn->close();

exit;
?>