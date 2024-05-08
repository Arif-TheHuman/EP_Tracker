<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$dbname = "calendarDB";
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    echo "Error checking/creating database: " . $conn->error;
}

// Select the database
$conn->select_db($dbname);

// Create table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS events (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    year INT(4) NOT NULL,
    date VARCHAR(30) NOT NULL,
    event VARCHAR(255) NOT NULL
    )";

if ($conn->query($sql) !== TRUE) {
    echo "Error checking/creating table: " . $conn->error;
}

// Insert data into database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['year']) && isset($_POST['date']) && isset($_POST['event'])) {
    $year = $_POST['year'];
    $date = $_POST['date'];
    $event = $_POST['event'];

    $sql = "INSERT INTO events (year, date, event) VALUES ('$year', '$date', '$event')";

    if ($conn->query($sql) !== TRUE) {
        echo "Error inserting record: " . $conn->error;
    }
}

// Delete data from database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete']) && is_numeric($_POST['delete'])) {
    $id = $_POST['delete'];

    $sql = "DELETE FROM events WHERE id = $id";

    if ($conn->query($sql) !== TRUE) {
        echo "Error deleting record: " . $conn->error;
    }
}

// Get data from database
$sql = "SELECT id, year, date, event FROM events ORDER BY year";
$result = $conn->query($sql);

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[$row['year']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php foreach ([2022, 2023, 2024] as $year) : ?>
        <h1><?php echo $year; ?></h1>
        <form method="post">
            <input type="hidden" name="year" value="<?php echo $year; ?>">
            <input type="text" name="date" placeholder="Date">
            <input type="text" name="event" placeholder="Event">
            <button type="submit">create</button>
        </form>
        <?php if (isset($events[$year])) : ?>
            <?php foreach ($events[$year] as $event) : ?>
                <p>
                    <?php echo $event['date'] . ': ' . $event['event']; ?>
                <form method="post">
                    <input type="hidden" name="delete" value="<?php echo $event['id']; ?>">
                    <button type="submit">delete</button>
                </form>
                </p>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</body>

</html>