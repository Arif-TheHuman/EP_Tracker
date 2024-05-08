<?php
include '../db_connection.php';

// Get year from URL, default to 2022 if not provided
$year = isset($_GET['year']) ? $_GET['year'] : 2022;

// Get data from database
$sql = "SELECT id, name, date, SUBSTRING(date, 1, 4) as year FROM events WHERE SUBSTRING(date, 1, 4) = $year ORDER BY date";
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
</head>
<body class="bg-white">
    <header class="p-6 flex justify-between items-center bg-cover" style="background-image: url('assets/background.jpg');">
        <h1 class="text-white text-lg"></h1>
        <div onclick="window.location.href='../profile/profile.php'" class="bg-white rounded-full">
            <img class="w-12 h-12 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Picture">
        </div>
    </header>
    <div class="p-5">
        <h1><?php echo $year; ?></h1>
    </div>
    <img class="mx-auto pb-5" src="assets/girl.png" alt="" style="height: 210px">
    <nav class="bg-blue-500 overflow-auto">
        <ul class="flex list-none m-0 p-0">
            <li class="float-left"><a href="calendar.php?year=2022" class="block text-white text-center px-4 py-2 no-underline">2022</a></li>
            <li class="float-left"><a href="calendar.php?year=2023" class="block text-white text-center px-4 py-2 no-underline">2023</a></li>
            <li class="float-left"><a href="calendar.php?year=2024" class="block text-white text-center px-4 py-2 no-underline">2024</a></li>
        </ul>
    </nav>
    <table class="table-auto w-full mx-auto border-collapse">
        <thead>
            <tr>
                <th class="px-4 py-2 border border-gray-200 bg-blue-500 text-left font-bold">Date</th>
                <th class="px-4 py-2 border border-gray-200 bg-blue-500 text-left font-bold">Event</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event) : ?>
                <tr>
                    <td class="px-4 py-2 border border-gray-200 text-left"><?php echo $event['date']; ?></td>
                    <td class="px-4 py-2 border border-gray-200 text-left"><?php echo $event['name']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>