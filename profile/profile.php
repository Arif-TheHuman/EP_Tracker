<?php
session_start(); // Start the session
include '../db_connection.php';
if (isset($_SESSION['user']['username'])) {
    $username = $_SESSION['user']['username']; // Set the $username variable
} else {
    echo "Username is not set in the session";
    exit(); // Stop the script if the username is not set in the session
}

// Fetch the user's data from the database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <header class="p-6 flex justify-between items-center bg-cover" style="background-image: url('../calendar/assets/background.jpg'); position: relative;">
        <div class="back-button">
            <a href="../home/index.php" class="m-4 bg-transparent text-white font-bold py-2 px-4 rounded-full border-2 border-white hover:bg-white hover:text-blue-500">Back</a>
        </div>
        <h1 class="text-white text-lg"></h1>

    </header>

    <div class="container mx-auto px-4">
        <div class="flex justify-center items-center min-h-screen">
            <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
                <div class="flex justify-center">
                    <img class="w-24 h-24 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Image">
                </div>
                <h1 class="text-2xl font-bold text-center mt-4">Profile</h1>
                <div class="mt-4">
                    <h2 class="text-xl">Name</h2>
                    <p class="text-gray-600"><?php echo $user['username']; ?></p>
                </div>
                <div class="mt-4">
                    <h2 class="text-xl">Email Address</h2>
                    <p class="text-gray-600"><?php echo $user['email']; ?></p>
                </div>
                <div class="mt-4">
                    <h2 class="text-xl">Phone Number</h2>
                    <p class="text-gray-600"><?php echo $user['phone_number']; ?></p>
                </div>
                <div class="mt-4">
                    <h2 class="text-xl">Role Type</h2>
                    <p class="text-gray-600"><?php echo $user['role']; ?></p>
                </div>
                <div class="mt-4">
                    <h2 class="text-xl">Group & Club</h2>
                    <p class="text-gray-600"><?php echo $user['userRoleSchool']; ?></p>
                </div>
                <div class="flex justify-between mt-6">
                    <button onclick="window.location.href='../home/progress.php'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Enrichment Point
                    </button>
                    <button onclick="window.location.href='edit_profile.php'" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Edit Profile
                    </button>
                    <a href="../logout/logout.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Log out
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>