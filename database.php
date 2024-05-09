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

// Check if the 'ep' column exists in the 'users' table
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'users' AND COLUMN_NAME = 'ep'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    // The 'ep' column does not exist, so add it
    $sql = "ALTER TABLE users ADD COLUMN ep INT NOT NULL DEFAULT 0";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding column: " . $conn->error;
    }
}

// Check if the 'sem' column exists in the 'users' table
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'users' AND COLUMN_NAME = 'sem'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    // The 'sem' column does not exist, so add it
    $sql = "ALTER TABLE users ADD COLUMN sem INT NOT NULL DEFAULT 1";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding column: " . $conn->error;
    }
}

$userUsername = "UserMan";
$userPassword = "a";
$userRole = "user";

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userUsername);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    // The 'UserMan' user does not exist, so insert it
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $userUsername, $userPassword, $userRole);
    if ($stmt->execute() !== TRUE) {
        echo "Error creating 'UserMan' user: " . $conn->error;
    }
}

// Create events table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS events (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

// Create user_events table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS user_events (
    user_id INT(6) UNSIGNED NOT NULL,
    event_id INT(6) UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES events(id),
    UNIQUE(user_id, event_id)
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

// Modify events table to include 'ep' column
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'events' AND COLUMN_NAME = 'ep'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $sql = "ALTER TABLE events ADD COLUMN ep INT NOT NULL DEFAULT 0";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding column: " . $conn->error;
    }
}

// Check if the 'sem' column exists in the 'events' table
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'events' AND COLUMN_NAME = 'sem'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    // The 'sem' column does not exist, so add it
    $sql = "ALTER TABLE events ADD COLUMN sem ENUM('1', '2', '3', '4') NOT NULL DEFAULT '1'";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding column: " . $conn->error;
    }
}


// Insert dummy data into events table
$events = [
    ['Football Tournament', 'A tournament for football enthusiasts', '2024-5-15', 5, 1],
    ['Coding Hackathon', 'A 24-hour coding challenge', '2024-5-20', 10, 2],
    ['Art Exhibition', 'An exhibition showcasing local artists', '2024-5-30', 5, 3],
    ['Music Festival', 'A festival featuring local bands', '2024-6-05', 5, 4],
    ['Science Fair', 'A fair for showcasing science projects', '2024-6-15', 5, 1],
    ['Literature Conference', 'A conference for literature enthusiasts', '2024-6-20', 10, 2],
    ['Tech Expo', 'An expo showcasing latest tech innovations', '2024-6-30', 10, 3],
];
foreach ($events as $event) {
    // Check if the event already exists
    $sql = "SELECT * FROM events WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $event[0]);
    $stmt->execute();
    $result = $stmt->get_result();
    // If the event does not exist, insert it
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO events (name, description, date, ep, sem) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $event[0], $event[1], $event[2], $event[3], $event[4]);
        if ($stmt->execute() !== TRUE) {
            echo "Error inserting event: " . $conn->error;
        }
    }
}

// Remove 'sem' column from 'events' table
$sql = "ALTER TABLE events DROP COLUMN sem";
if ($conn->query($sql) !== TRUE) {
    echo "Error removing column: " . $conn->error;
}

// Check if the 'sem' column exists in the 'user_events' table
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'user_events' AND COLUMN_NAME = 'sem'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    // The 'sem' column does not exist, so add it
    $sql = "ALTER TABLE user_events ADD COLUMN sem ENUM('1', '2', '3', '4', '5', '6') NOT NULL";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding column: " . $conn->error;
    }
}

// Insert dummy data into user_events table
// Assuming the user ID and event IDs are known
$userEvents = [
    [1, 1, 3], // User 1 attended event 1
    [1, 2, 3], // User 1 attended event 2
    [1, 7, 4],
    [1, 8, 4],
    [2, 1, 4],
    [2, 2, 4],
    [2, 3, 4],
    [2, 4, 4],
    [2, 5, 5],
    [2, 6, 5],
];
foreach ($userEvents as $userEvent) {
    if (!empty($userEvent)) {
        $sql = "INSERT IGNORE INTO user_events (user_id, event_id, sem) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $userEvent[0], $userEvent[1], $userEvent[2]);
        if ($stmt->execute() !== TRUE) {
            echo "Error inserting user event: " . $conn->error;
        }
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
    taskbarBgImg VARCHAR(255) NOT NULL,
    headnav VARCHAR(255) NOT NULL,
    bgforcontent VARCHAR(255) NOT NULL

  )";
  if ($conn->query($sql) !== TRUE) {
      echo "Error creating table: " . $conn->error;
  }
// Insert dummy data into clubs table
$clubs = [
    ['Volleyball Club', 'A club for volleyball enthusiasts.', 'outdoor', 20, 50, 'img1.jpg', '../assets/clubs/outdoor/volleyballclubbg.png', '../assets/clubs/outdoor/volleyballclub.png','../assets/clubs/outdoor/volleyballclub.png', '../assets/clubs/outdoor/volleyballclubbg.png','../assets/clubs/outdoor/taskbarimg1.jpg', '../assets/clubs/outdoor/VB HEADER.png', '../assets/clubs/outdoor/VB BG FOR CONTENT.png'],
    ['Touch Rugby Club', 'A club for rough and tough Rugby enthusiasts.', 'outdoor', 20, 50, 'img1.jpg', '../assets/clubs/outdoor/rugbybg.png', '../assets/clubs/outdoor/rugbyclub.png','../assets/clubs/outdoor/rugbyclub.png', '../assets/clubs/outdoor/rugbybg.png','../assets/clubs/outdoor/taskbarimg1.jpg', '../assets/clubs/outdoor/RUG HEADER.png', '../assets/clubs/outdoor/RUG BG FOR CONTENT.png'],
    ['Swimming Club', 'A club for fighting dreamers, fighting swimmers.', 'outdoor', 20, 50, 'img1.jpg', '../assets/clubs/outdoor/swimmingclubbg.png', '../assets/clubs/outdoor/swimmingclub.png', '../assets/clubs/outdoor/swimmingclub.png', '../assets/clubs/outdoor/swimmingclubbg.png','../assets/clubs/outdoor/taskbarimg1.jpg', '../assets/clubs/outdoor/SWIM HEADER.png', '../assets/clubs/outdoor/SWIM BG FOR CONTENT.png'],
    ['Kelab Nasyidul Islam', 'A club for those who enjoys religious songs and nasyids', 'indoor', 15, 30, 'img1.jpg', '../assets/clubs/indoor/knibg.png', '../assets/clubs/indoor/kni.png','../assets/clubs/indoor/kni.png', '../assets/clubs/indoor/knibg.png','../assets/clubs/indoor/taskbarimg2.jpg', '../assets/clubs/indoor/KNI HEADER.png', '../assets/clubs/indoor/KNI BG FOR CONTENT.png'],
    ['Lets Japan Club', 'A club for those who enjoy learning Japanese Cultures.', 'indoor', 15, 30, 'img1.jpg', '../assets/clubs/indoor/letsjapanbg.png', '../assets/clubs/indoor/letsjapan.png','../assets/clubs/indoor/letsjapan.png', '../assets/clubs/indoor/letsjapanbg.png','../assets/clubs/indoor/taskbarimg2.jpg', '../assets/clubs/indoor/JP HEADER.png', '../assets/clubs/indoor/JP BG FOR CONTENT.png'],
    ['Art Club', 'A club for those who enjoy creating and appreciating art', 'indoor', 15, 30, 'img1.jpg', '../assets/clubs/indoor/artclubbg.png', '../assets/clubs/indoor/artclub.png','../assets/clubs/indoor/artclub.png', '../assets/clubs/indoor/artclubbg.png','../assets/clubs/indoor/taskbarimg2.jpg', '../assets/clubs/indoor/ART HEADER.png', '../assets/clubs/indoor/ART BG FOR CONTENT.png'],
    // Add more clubs as needed
];

// Create news table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS news (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

// Insert dummy data into news table
$newsItems = [
    ['Convo Volunteers', 'Open to all PB students. Join us! Interested students can register now. Deadline of registration: 11th October 2023', 'assets/images/bgcard1.png'],
    ['HIV Awareness Programme', 'HIV Awareness Programme for Peers and Youth is now open for registration. Interested students can register now. #EndorsedforEP #HAPPY #SAD', 'assets/images/happy.png'],
    ['Sign Language Workshop', 'Sign Language Workshop (Level 2) is now open for registration. Interested students can register now. Limit to only 40 students', 'assets/images/signal.png'],
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
        $sql = "INSERT INTO news (title, description, image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $newsItem[0], $newsItem[1], $newsItem[2]);
        if ($stmt->execute() !== TRUE) {
            echo "Error inserting news item: " . $conn->error;
        }
    }
}
$stmt->close();

foreach ($clubs as $club) {
    // Check if the club already exists
    $sql = "SELECT * FROM clubs WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $club[0]);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the club does not exist, insert it
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO clubs (name, description, type, current_members, quota, img1, img2, img3, profilePic, coverPic, taskbarBgImg, headnav, bgforcontent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiissssssss", $club[0], $club[1], $club[2], $club[3], $club[4], $club[5], $club[6], $club[7], $club[8], $club[9], $club[10], $club[11], $club[12]);
        if ($stmt->execute() !== TRUE) {
            echo "Error inserting club: " . $conn->error;
        }
    }
}

// Create club_sessions table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS club_sessions (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    club_id INT(6) UNSIGNED NOT NULL,
    session_date DATE NOT NULL,
    time_slot VARCHAR(255) NOT NULL default '2pm - 4pm',
    FOREIGN KEY (club_id) REFERENCES clubs(id)
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

$years = [2022, 2023, 2024];
$months = ['02' => 'February', '03' => 'March', '08' => 'August', '09' => 'September'];

foreach ($years as $year) {
    foreach ($clubs as $club) {
        $clubName = $club[0];

        // Get the club id
        $sql = "SELECT id FROM clubs WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $clubName);
        $stmt->execute();
        $result = $stmt->get_result();
        $clubId = $result->fetch_assoc()['id'];

        // Initialize the session counter for the club for this year
        $sessionCount = 0;

        foreach ($months as $monthNum => $monthName) {
            // Start from the first day of the month
            $sessionDate = date("Y-m-d", strtotime("$year-$monthNum-01"));

            // Loop until the session date reaches the next month or the session count reaches 7
            while (date('m', strtotime($sessionDate)) == $monthNum && $sessionCount < 7) {
                // Check if the session already exists
                $sql = "SELECT * FROM club_sessions WHERE club_id = ? AND session_date = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $clubId, $sessionDate);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 0) {
                    // Insert the session into the sessions table
                    $sql = "INSERT INTO club_sessions (club_id, session_date) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("is", $clubId, $sessionDate);
                    if ($stmt->execute() !== TRUE) {
                        echo "Error inserting session: " . $conn->error;
                    } else {
                        // Increment the session count
                        $sessionCount++;
                    }
                }

                // Increment the session date by 1 week
                $sessionDate = date("Y-m-d", strtotime("$sessionDate +1 week"));
            }

            // If the session count has reached 7, break the loop for this club for this year
            if ($sessionCount >= 7) {
                break;
            }
        }
    }
}

// Create user_sessions table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS user_sessions (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    session_id INT(6) UNSIGNED NOT NULL,
    attendance_status ENUM('attended', 'absent', 'cancelled', 'none') NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (session_id) REFERENCES club_sessions(id)
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

// Define the attendance statuses
$attendance_statuses = ['attended', 'absent', 'cancelled', 'none'];

// Fetch all user IDs from the users table
$sql = "SELECT id FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $user_id = $row["id"];

        // Fetch the maximum session_id for the current user
        $sql = "SELECT MAX(session_id) as max_session_id FROM user_sessions WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $max_session_id = $row['max_session_id'];

        for ($i = 1; $i <= $max_session_id; $i++) {
            // If it's the last session (i.e., session_id == max_session_id), set the status to 'none'
            $attendance_status = $i == $max_session_id ? 'none' : $attendance_statuses[array_rand($attendance_statuses)];

            // Insert the dummy data into the user_sessions table
            $sql = "INSERT INTO user_sessions (user_id, session_id, attendance_status) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iis", $user_id, $i, $attendance_status);
            if ($stmt->execute() !== TRUE) {
                echo "Error inserting dummy data: " . $conn->error;
            }
        }
    }
}

// Create user_clubs table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS user_clubs (
    user_id INT(6) UNSIGNED NOT NULL,
    club_id INT(6) UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (club_id) REFERENCES clubs(id),
    UNIQUE(user_id, club_id)
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
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

$sql = "UPDATE users SET ep = (
    SELECT SUM(events.ep) 
    FROM user_events 
    JOIN events ON user_events.event_id = events.id 
    WHERE user_events.user_id = users.id
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error updating 'ep' column in 'users' table: " . $conn->error;
}


exit;
?>