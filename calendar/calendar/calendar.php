<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendarDB"; // specify the database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from database
$sql = "SELECT id, year, date, event FROM events WHERE year = 2023 ORDER BY date";
$result = $conn->query($sql);

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

$conn->commit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            /* Adjust width as needed */
            margin: 0 auto;
            /* Center the table */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #03A4FF;
            font-weight: bold;
        }

        p {
            text-align: center;
            margin-top: 10px;
        }

        a {
            color: #333;
            text-decoration: none;
            margin: 5px;
        }

        a:hover {
            color: #666;
            cursor: pointer;
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding-bottom: 20px;
        }

        .navbar {
            background-color: #03A4FF;
            overflow: auto;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .navbar li {
            float: left;
        }

        .navbar a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #111;
        }
    </style>
</head>

<body>
    <!-- <h1>CALENDAR</h1> -->

    <header class="p-6 flex justify-between items-center" style="background-image: url('assets/background.jpg');">
        <h1 class="text-white text-lg"></h1>
        <div onclick="window.location.href='../profile/profile.php'" class="bg-white rounded-full">
            <img class="w-12 h-12 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Picture">
        </div>
    </header>



    <div style="padding: 20px;">
        <h1>CALENDAR</h1>
    </div>

    <img class="center" src="assets/girl.png" alt="" style="height: 210px">

    <nav class="navbar">
        <ul>
            <li><a href="calendar2022.php">2022</a></li>
            <li><a href="">2023</a></li>
            <li><a href="calendar2024.php">2024</a></li>
        </ul>
    </nav>

    <div style="padding: 20px;">
        <h1>2023</h1>
    </div>


    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Event</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event) : ?>
                <tr>
                    <td><?php echo $event['date']; ?></td>
                    <td><?php echo $event['event']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>