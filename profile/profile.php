<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        input {
            width: 400px;
        }
    </style>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <!-- Navigation Bar -->
    <!-- <nav class="bg-white p-4">
        <div class="container mx-auto flex items-center justify-between">
            <a class="text-lg font-semibold text-gray-900" href="#">EP Tracker</a>
            <div class="space-x-4">
                <a class="text-gray-600 hover:text-gray-900" href="#">Home</a>
                <a class="text-gray-600 hover:text-gray-900" href="#">About</a>
                <a class="text-gray-600 hover:text-gray-900" href="#">Contact</a>
            </div>
        </div> -->
    <!-- </nav> -->
    <!-- Hero Section -->
    <header class="text-white text-center py-16 mb-8" style="background-image: url('assets/background.jpg'); background-size: cover; background-position: center;">
        <div class="container mx-auto">
            <div class="bg-white rounded-full p-2 inline-block">
                <img class="w-32 h-32 mx-auto rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Image">
            </div>
        </div>
    </header>

    <!-- bio starts here -->
    <div style="margin-left: 490px; margin-right: 500px;">
        <div>
            <div class="flex justify-between items-center">
                <h1>&nbsp;Name</h1>
            </div>
            <input type="text">
        </div>

        <div>
            <div class="flex justify-between items-center">
                <h1>&nbsp;Email Address</h1>
            </div>
            <input type="text">
        </div>

        <div>
            <div class="flex justify-between items-center">
                <h1>&nbsp;Phone Number</h1>
            </div>
            <input type="text">
        </div>

        <div>
            <h1>&nbsp;Role Type</h1>
            <input type="text">
        </div>

        <div>
            <h1>&nbsp;Group & Club</h1>
            <input type="text">
        </div>
    </div>
    <!-- bio ends -->


    <!-- the two buttons starts here -->
    <div class="flex justify-center mt-4">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-2">
            Enrichment Points
        </button>
        <button onclick="window.location.href='edit_profile.php'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-2">
            Edit Profile
        </button>
        <button onclick="window.location.href='testing.php'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-2">
            Log Out
        </button>
    </div>
    <!-- the two buttons ends here -->



    <br>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto text-center">
            <p>Copyright &copy; 2024 EP Tracker</p>
        </div>
    </footer>
</body>

</html>