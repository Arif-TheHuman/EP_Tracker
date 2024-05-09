<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "ECPS";
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
$conn->select_db($dbName);
