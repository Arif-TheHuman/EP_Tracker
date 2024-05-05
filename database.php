<?php
include 'db_connection.php';

$adminUsername = "admin";
$adminPassword = "admin";
$adminRole = "admin";

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
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'users' AND COLUMN_NAME = 'role'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $sql = "ALTER TABLE users ADD COLUMN role ENUM('user', 'admin') NOT NULL DEFAULT 'user'";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding column: " . $conn->error;
    }
}
// Check if the admin user already exists
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $adminUsername);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    // The admin user does not exist, so insert it
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $adminUsername, $adminPassword, $adminRole);
    if ($stmt->execute() !== TRUE) {
        echo "Error creating admin user: " . $conn->error;
    }
}
$stmt->close();
// Create clubs table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS clubs (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    type ENUM('indoor', 'outdoor', 'society') NOT NULL,
    current_members INT(6) NOT NULL DEFAULT 0,
    quota INT(6) NOT NULL DEFAULT 0,
    img1 VARCHAR(255) NOT NULL,
    img2 VARCHAR(255) NOT NULL,
    img3 VARCHAR(255) NOT NULL,
    profilePic VARCHAR(255) NOT NULL,
    coverPic VARCHAR(255) NOT NULL,
    taskbarBgImg VARCHAR(255) NOT NULL
  )";
  if ($conn->query($sql) !== TRUE) {
      echo "Error creating table: " . $conn->error;
  }
// Insert dummy data into clubs table
$clubs = [
    ['Volleyball Club', 'A club for volleyball enthusiasts.', 'outdoor', 20, 50, 'img1.jpg', '../assets/volleyballclubbg.png', '../assets/volleyballclub.png','../assets/volleyballclub.png', '../assets/volleyballclubbg.png','taskbarimg1.jpg'],
    ['Touch Rugby Club', 'A club for rough and tough Rugby enthusiasts.', 'outdoor', 20, 50, 'img1.jpg', '../assets/rugbyclub.png', 'img3.jpg','prof1.jpg', '../assets/rugbybg.png','taskbarimg1.jpg'],
    ['Swimming Club', 'A club for fighting dreamers, fighting swimmers.', 'outdoor', 20, 50, 'swimmingclub.png', 'img2.jpg', 'img3.jpg','prof1.jpg', 'swimmingclubbg.png','taskbarimg1.jpg'],
    ['Chess Club', 'A club for those who enjoy playing chess.', 'indoor', 15, 30, 'img4.jpg', 'img5.jpg', 'img6.jpg','prof2.jpg', 'coverimg2.jpg','taskbarimg2.jpg'],
    // Add more clubs as needed
];

// Create news table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS news (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    link VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

// Insert dummy data into news table
$newsItems = [
    ['HIV Awareness Programme', 'HIV Awareness Programme for Peers and Youth is now open for registration. Interested students can register now. #EndorsedforEP #HAPPY #SAD', 'assets/images/happy.png', 'hivaware.php'],
    ['Convo Volunteers', 'Open to all PB students. Join us! Interested students can register now. Deadline of registration: 11th October 2023', 'assets/images/bgcard1.png', 'convoVolunteer.php'],
    ['Sign Language Workshop', 'Sign Language Workshop (Level 2) is now open for registration. Interested students can register now. Limit to only 40 students', 'assets/images/signal.png', 'signWorkshop.php'],
    // Add more news items as needed
];

// Create registrations table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS registrations (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    news_id INT(6) UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

$sql = "ALTER TABLE registrations ADD FOREIGN KEY (news_id) REFERENCES news(id)";
if ($conn->query($sql) !== TRUE) {
    echo "Error adding foreign key: " . $conn->error;
}

foreach ($newsItems as $newsItem) {
    // Check if the news item already exists
    $sql = "SELECT * FROM news WHERE title = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $newsItem[0]);
    $stmt->execute();
    $result = $stmt->get_result();
    // If the news item does not exist, insert it
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO news (title, description, image, link) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $newsItem[0], $newsItem[1], $newsItem[2], $newsItem[3]);
        if ($stmt->execute() !== TRUE) {
            echo "Error inserting news item: " . $conn->error;
        }
    }
}
$stmt->close();


// Create table for indoor club if it doesn't exist

// No need for this, we are using a single clubs table for both indoor and outdoor clubs, and club type is stored in the 'type' column
// $sql = "CREATE TABLE IF NOT EXISTS indoorClubs (
//     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(50) NOT NULL,
//     description TEXT NOT NULL,
//     current_members INT(6) NOT NULL DEFAULT 0,
//     quota INT(6) NOT NULL DEFAULT 0,
//     img1 VARCHAR(255) NOT NULL,
//     img2 VARCHAR(255) NOT NULL,
//     img3 VARCHAR(255) NOT NULL,
//     profilePic VARCHAR(255) NOT NULL,
//     coverPic VARCHAR(255) NOT NULL,
//     taskbarBgImg VARCHAR(255) NOT NULL
//   )";
//   if ($conn->query($sql) !== TRUE) {
//       echo "Error creating table: " . $conn->error;
//   }


foreach ($clubs as $club) {
    // Check if the club already exists
    $sql = "SELECT * FROM clubs WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $club[0]);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the club does not exist, insert it
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO clubs (name, description, type, current_members, quota, img1, img2, img3, profilePic, coverPic, taskbarBgImg) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiissssss", $club[0], $club[1], $club[2], $club[3], $club[4], $club[5], $club[6], $club[7], $club[8], $club[9], $club[10]);
        if ($stmt->execute() !== TRUE) {
            echo "Error inserting club: " . $conn->error;
        }
    }
}
$stmt->close();
$conn->close();
// Start the session
session_start();
// Redirect to the appropriate page based on the user role
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    header("Location: ./admin/dashboard.php");
} else {
    header("Location: login.php");
}
exit;
?>