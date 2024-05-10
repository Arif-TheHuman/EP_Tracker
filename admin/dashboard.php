<?php
include '../db_connection.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <header class="p-6 flex justify-between items-center bg-cover" style="background-image: url('../calendar/assets/background.jpg'); position: relative;">
        <div class="back-button">
            <a href="../home/index.php" class="m-4 bg-transparent text-white font-bold py-2 px-4 rounded-full border-2 border-white hover:bg-white hover:text-blue-500">Back</a>
        </div>
        <div class="back-button">
            <a href="../login.php" class="m-4 bg-transparent text-white font-bold py-2 px-4 rounded-full border-2 border-white hover:bg-white hover:text-blue-500">Logout</a>
        </div>
    </header>

    <div class=" flex justify-center text-center mt-10 mb-10">
        <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold leading-tight text-gray-900">
            <span class="block">Admin dashboard</span>
        </h1>
    </div>
    <div class="container align-center justify-center items-center sm:ml-12 md:ml-6 lg:ml-6 px-4 flex flex-wrap md:flex-no-wrap lg:flex-wrap">
        <div class="w-full lg:w-3/4 md:w-2/4 sm:w-2/4 p-3">
            <button onclick="window.location.href='club.php'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block w-full">
                <a href="club.php" class="text-white no-underline">Clubs</a>
            </button>
        </div>
        <div class="w-full lg:w-3/4 md:w-2/4 sm:w-2/4 p-3">
            <button onclick="window.location.href='news.php'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block w-full">
                <a href="news.php" class="text-white no-underline">News</a>
            </button>
        </div>
        <div class="w-full lg:w-3/4 md:w-2/4 sm:w-2/4 p-3">
            <button onclick="window.location.href='events.php'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block w-full">
                <a href="events.php" class="text-white no-underline">Events</a>
            </button>
        </div>
    </div>
</body>

</html>