<?php
include 'db_connection.php';

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

// Check if the 'email' column exists in the 'users' table
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'users' AND COLUMN_NAME = 'email'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    // The 'email' column does not exist, so add it
    $sql = "ALTER TABLE users ADD COLUMN email VARCHAR(255) NOT NULL";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding column: " . $conn->error;
    }
}

// Check if the 'phone_number' column exists in the 'users' table
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'users' AND COLUMN_NAME = 'phone_number'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    // The 'phone_number' column does not exist, so add it
    $sql = "ALTER TABLE users ADD COLUMN phone_number VARCHAR(15) NOT NULL";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding column: " . $conn->error;
    }
}

// Check if the 'userRoleSchool' column exists in the 'users' table
$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'users' AND COLUMN_NAME = 'userRoleSchool'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    // The 'userRoleSchool' column does not exist, so add it
    $sql = "ALTER TABLE users ADD COLUMN userRoleSchool ENUM('member', 'non-member') NOT NULL DEFAULT 'member'";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding column: " . $conn->error;
    }
}

$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = 'users' AND COLUMN_NAME = 'role'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    $sql = "ALTER TABLE users ADD COLUMN role ENUM('user', 'admin') NOT NULL DEFAULT 'user'";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding column: " . $conn->error;
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

$adminUsername = "admin";
$adminPassword = "admin";
$adminRole = "admin";
$adminSchoolRole = "admin";
$adminPhoneNumber = "1234567890";
$adminEmail = "PoliAdmin@gmail.com";

// Check if the admin user already exists
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $adminUsername);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    $sql = "INSERT INTO users (username, password, role, email, phone_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $adminUsername, $adminPassword, $adminRole, $adminEmail, $adminPhoneNumber);
    if ($stmt->execute() !== TRUE) {
        echo "Error creating admin user: " . $stmt->error;
    }
}

$userUsername = "UserMan";
$userPassword = "a";
$userRole = "user";
$userSchoolRole = "member";
$userPhoneNumber = "987654321";
$userEmail = "userman@gmail.com";

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userUsername);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    // The 'UserMan' user does not exist, so insert it
    $sql = "INSERT INTO users (username, password, role, email, phone_number, userRoleSchool) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $userUsername, $userPassword, $userRole, $userEmail, $userPhoneNumber, $userSchoolRole);
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
    bgforcontent VARCHAR(255) NOT NULL,
    contentNO1 VARCHAR(255) NOT NULL,
    contentNO2 VARCHAR(255) NOT NULL,
    contentNO3 VARCHAR(255) NOT NULL
  )";
  if ($conn->query($sql) !== TRUE) {
      echo "Error creating table: " . $conn->error;
  }
// Insert dummy data into clubs table
$clubs = [
    ['Volleyball Club', 'A club for volleyball enthusiasts.', 'outdoor', 20, 50, 'img1.jpg', '../assets/clubs/outdoor/volleyballclubbg.png', '../assets/clubs/outdoor/volleyballclub.png','../assets/clubs/outdoor/volleyballclub.png', '../assets/clubs/outdoor/volleyballclubbg.png','../assets/clubs/outdoor/GYAT_mek.jpg', '../assets/clubs/outdoor/VB HEADER.png', '../assets/clubs/outdoor/VB BG FOR CONTENT.png', '../assets/clubs/outdoor/VB CONTENT NO1.png', '../assets/clubs/outdoor/VB CONTENT NO2.png', '../assets/clubs/outdoor/VB CONTENT NO3.png'],
    ['Touch Rugby Club', 'A club for rough and tough Rugby enthusiasts.', 'outdoor', 20, 50, 'img1.jpg', '../assets/clubs/outdoor/rugbybg.png', '../assets/clubs/outdoor/rugbyclub.png','../assets/clubs/outdoor/rugbyclub.png', '../assets/clubs/outdoor/rugbybg.png','../assets/clubs/outdoor/GYAT_mek.jpg', '../assets/clubs/outdoor/RUG HEADER.png', '../assets/clubs/outdoor/RUG BG FOR CONTENT.png', '../assets/clubs/outdoor/RUG CONTENT NO1.png', '../assets/clubs/outdoor/RUG CONTENT NO2.png', '../assets/clubs/outdoor/RUG CONTENT NO3.png'],
    ['Swimming Club', 'A club for fighting dreamers, fighting swimmers.', 'outdoor', 20, 50, 'img1.jpg', '../assets/clubs/outdoor/swimmingclubbg.png', '../assets/clubs/outdoor/swimmingclub.png', '../assets/clubs/outdoor/swimmingclub.png', '../assets/clubs/outdoor/swimmingclubbg.png','../assets/clubs/outdoor/GYAT_mek.jpg', '../assets/clubs/outdoor/SWIM HEADER.png', '../assets/clubs/outdoor/SWIM BG FOR CONTENT.png', '../assets/clubs/outdoor/SWIM CONTENT NO1.png', '../assets/clubs/outdoor/SWIM CONTENT NO2.png', '../assets/clubs/outdoor/SWIM CONTENT NO3.png'],
    ['Kelab Nasyidul Islam', 'A club for those who enjoys religious songs and nasyids', 'indoor', 15, 30, 'img1.jpg', '../assets/clubs/indoor/knibg.png', '../assets/clubs/indoor/kni.png','../assets/clubs/indoor/kni.png', '../assets/clubs/indoor/knibg.png','../assets/clubs/indoor/GYAT_mek.jpg', '../assets/clubs/indoor/KNI HEADER.png', '../assets/clubs/indoor/KNI BG FOR CONTENT.png', '../assets/clubs/indoor/KNI CONTENT NO1.png', '../assets/clubs/indoor/KNI CONTENT NO2.png', '../assets/clubs/indoor/KNI CONTENT NO3.png'],
    ['Lets Japan Club', 'A club for those who enjoy learning Japanese Cultures.', 'indoor', 15, 30, 'img1.jpg', '../assets/clubs/indoor/letsjapanbg.png', '../assets/clubs/indoor/letsjapan.png','../assets/clubs/indoor/letsjapan.png', '../assets/clubs/indoor/letsjapanbg.png','../assets/clubs/indoor/GYAT_mek.jpg', '../assets/clubs/indoor/JP HEADER.png', '../assets/clubs/indoor/JP BG FOR CONTENT.png', '../assets/clubs/indoor/JP CONTENT NO1.png', '../assets/clubs/indoor/JP CONTENT NO2.png', '../assets/clubs/indoor/JP CONTENT NO3.png'],
    ['Art Club', 'A club for those who enjoy creating and appreciating art', 'indoor', 15, 30, 'img1.jpg', '../assets/clubs/indoor/artclubbg.png', '../assets/clubs/indoor/artclub.png','../assets/clubs/indoor/artclub.png', '../assets/clubs/indoor/artclubbg.png','../assets/clubs/indoor/GYAT_mek.jpg', '../assets/clubs/indoor/ART HEADER.png', '../assets/clubs/indoor/ART BG FOR CONTENT.png', '../assets/clubs/indoor/ART CONTENT NO1.png', '../assets/clubs/indoor/ART CONTENT NO2.png', '../assets/clubs/indoor/ART CONTENT NO3.png'],
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
        $sql = "INSERT INTO clubs (name, description, type, current_members, quota, img1, img2, img3, profilePic, coverPic, taskbarBgImg, headnav, bgforcontent, contentNO1, contentNO2, contentNO3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiisssssssssss", $club[0], $club[1], $club[2], $club[3], $club[4], $club[5], $club[6], $club[7], $club[8], $club[9], $club[10], $club[11], $club[12], $club[13], $club[14], $club[15]);
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
    FOREIGN KEY (club_id) REFERENCES clubs(id),
    attendance ENUM('Absent', 'Present', 'Cancelled', 'None') NOT NULL DEFAULT 'None'
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

$years = [2022, 2023, 2024];
$months = ['02' => 'February', '03' => 'March', '08' => 'August', '09' => 'September'];
$attendance_statuses = ['Absent', 'Present', 'Cancelled', 'None'];

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
                    $sql = "INSERT INTO club_sessions (club_id, session_date, attendance) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    switch ($sessionCount) {
                        case 0:
                            $attendance = 'Present';
                            break;
                        case 1:
                            $attendance = 'Absent';
                            break;
                        case 2:
                            $attendance = 'Cancelled';
                            break;
                        default:
                            $attendance = (rand(0, 2) == 0) ? 'Present' : ((rand(0, 1) == 0) ? 'Absent' : 'Cancelled');
                            break;
                    }
                    $stmt->bind_param("iss", $clubId, $sessionDate, $attendance);
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
    session_id INT(6) UNSIGNED NOT NULL,
    attendance_status ENUM('attended', 'absent', 'cancelled', 'none') NOT NULL,
    FOREIGN KEY (session_id) REFERENCES club_sessions(id)
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}


// Check if user_id column already exists in user_sessions table
$result = $conn->query("SHOW COLUMNS FROM `user_sessions` LIKE 'user_id'");
if ($result->num_rows == 0) {
    // Add user_id column to user_sessions table
    $sql = "ALTER TABLE user_sessions ADD COLUMN user_id INT(6) UNSIGNED NOT NULL AFTER session_id, ADD FOREIGN KEY (user_id) REFERENCES users(id)";
    if ($conn->query($sql) !== TRUE) {
        echo "Error adding column: " . $conn->error;
    }
} else {
    echo "Column user_id already exists.";
}

// Define the attendance statuses
$attendance_statuses = ['attended', 'absent', 'cancelled'];

// Fetch all club IDs from the club_sessions table
$sql = "SELECT DISTINCT club_id FROM club_sessions";
$resultClubs = $conn->query($sql);

while($rowClub = $resultClubs->fetch_assoc()) {
    $club_id = $rowClub["club_id"];

    // Fetch the maximum session_id for the current club from the club_sessions table
    $sql = "SELECT MAX(id) as max_session_id FROM club_sessions WHERE club_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $club_id);
    $stmt->execute();
    $resultSessions = $stmt->get_result();
    $rowSession = $resultSessions->fetch_assoc();
    $max_session_id = $rowSession['max_session_id'];

    
// Assume a default user_id for the purpose of this example
$default_user_id = 2;

for ($i = 1; $i <= 7; $i++) {
    // If it's the last two sessions (i.e., session_id == max_session_id or max_session_id - 1), set the status to 'none'
    $attendance_status = $i >= $max_session_id - 1 ? 'none' : $attendance_statuses[array_rand($attendance_statuses)];

    // Insert the dummy data into the user_sessions table
    $sql = "INSERT INTO user_sessions (session_id, user_id, attendance_status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $i, $default_user_id, $attendance_status);
    if ($stmt->execute() !== TRUE) {
        echo "Error inserting dummy data: " . $conn->error;
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