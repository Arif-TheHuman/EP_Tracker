<?php
session_start(); // Start the session
include '../db_connection.php';
if (isset($_SESSION['user']['username'])) {
    $username = $_SESSION['user']['username']; // Set the $username variable
} else {
    echo "Username is not set in the session";
    exit(); // Stop the script if the username is not set in the session
}

$sql = "SELECT sem FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$sem = $row['sem'];

// Fetch user data
$sql = "SELECT id, sem, ep FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$userId = $row['id'];

// Fetch all the events for the current semester that the user has participated in
$sql = "SELECT events.* FROM events 
        JOIN user_events ON events.id = user_events.event_id 
        WHERE user_events.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$events = $result->fetch_all(MYSQLI_ASSOC);

$totalEP = 0; // Initialize total EP
foreach ($events as $event) {
    $totalEP += $event['ep']; // Add the EP of each event to the total
}

// Fetch all the events that the user has participated in, regardless of the semester
$sql = "SELECT events.* FROM events 
        JOIN user_events ON events.id = user_events.event_id 
        WHERE user_events.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$allEvents = $result->fetch_all(MYSQLI_ASSOC);

$totalAllEP = 0; // Initialize total EP for all events
foreach ($allEvents as $event) {
    $totalAllEP += $event['ep']; // Add the EP of each event to the total
}

$percentage = round($totalAllEP / 64 * 100); // Calculate the percentage based on total EP
if ($totalAllEP > 64) {
    $percentage = 100;
}
$req = 64 - $totalAllEP; // Calculate the required EP based on total EP
if ($totalAllEP > 64) {
    $req = 0;
}

// Fetch indoor clubs from the database
$sql = "SELECT * FROM clubs WHERE type='indoor'";
$result = $conn->query($sql);
$indoorClubs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $indoorClubs[] = $row;
    }
}

// Fetch outdoor clubs from the database
$sql = "SELECT * FROM clubs WHERE type='outdoor'";
$result = $conn->query($sql);
$outdoorClubs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $outdoorClubs[] = $row;
    }
}

// Fetch society clubs from the database
$sql = "SELECT * FROM clubs WHERE type='society'";
$result = $conn->query($sql);
$societyClubs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $societyClubs[] = $row;
    }
}

// Fetch the 'sem' column for the logged-in user
$sql = "SELECT sem FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userUsername);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EP Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="p-4 text-white fixed w-full z-50" style="background-image: url('../assets/figmatingy1.jpg'); background-size: cover; background-repeat: no-repeat;">
        <div class="container mx-auto flex items-center justify-between">
            <a class="text-lg font-semibold" href="#">EP Tracker</a>
            <div class="flex items-center space-x-4">
                <a class="hover:text-gray-300" href="#">Home</a>
                <a class="hover:text-gray-300" href="../clubs/club-page.php">Clubs</a>
                <a class="hover:text-gray-300" href="../newsPage/newspage.php">News</a>
                <a class="hover:text-gray-300" href="../calendar/calendar.php">Calendar</a>
                <a class="hover:text-gray-300" href="../aboutus.php">About Us</a>
                <a href="../profile/profile.php">
                    <img class="h-8 w-8 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Image">
                </a>
            </div>
        </div>
    </nav>
    <br><br><br>
    <div class="mt-16">
        <div class="container mx-auto flex justify-center items-center h-64 w-3/4 bg-gray-400 relative rounded-xl" style="background-image: url('../assets/homerectangle.png');"> <!-- Add relative here -->

            <a href="progress.php">
                <button class="absolute top-0 right-0 m-4 bg-transparent text-black font-bold py-2 px-4 rounded-full border-2 border-black">
                    +
                </button>
            </a>
            <svg class="w-64 h-48 mx-auto" viewBox="0 0 36 36">
                <path class="circle-bg" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#eee" stroke-width="2.5" />
                <path class="circle" stroke="#4c51bf" stroke-dasharray="<?php echo $percentage; ?>, 100" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke-width="2.5" stroke-linecap="round" />
                <text x="18" y="18" class="percentage" fill="#4c51bf" text-anchor="middle" dy=".3em" font-size="8"><?php echo $percentage; ?>%</text>
                <div class="w-1/2 text-center">
                    <h1 class="text-xl font-bold md:text-2xl sm:text-xl xl:text-3xl"><?php echo strtoupper($totalAllEP) ?> OUT OF 64 EP</h1>
                    <p class="text-lg sm:text-xl md:text- xl:text-2xl text-gray-700"><?php echo $req; ?> EP REQUIRED</p>
                    <p class="text-lg">SEMESTER <?php echo $sem; ?></p>
                </div>
            </svg>

        </div>
    </div>
    <br>
    <div>
        <h1 class="ml-5 text-xl">Indoor Clubs</h1>
        <div class="overflow-x-auto whitespace-nowrap py-4">
            <?php foreach ($indoorClubs as $club) : ?>
                <div class="inline-block mx-6 relative">
                    <a href="../clubs/club-details.php?name=<?php echo urlencode($club['name']); ?>">
                        <img class="w-64 h-64 sm:w-64 sm:h-96 md:w-64 md:h-128 lg:w-128 lg:h-128 object-cover rounded-xl" src="<?php echo $club['img2']; ?>" alt="<?php echo $club['name']; ?>">
                        <img class="w-16 h-16 object-cover rounded-full absolute bottom-0 transform -translate-x-1/2 -translate-y-3/4 left-1/2" src="<?php echo $club['img3']; ?>" alt="<?php echo $club['name']; ?>">
                        <p class="text-center"><?php echo $club['name']; ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div>
        <h1 class="ml-5 text-xl">Outdoor Clubs</h1>
        <div class="overflow-x-auto whitespace-nowrap py-4">
            <?php foreach ($outdoorClubs as $club) : ?>
                <div class="inline-block mx-6 relative">
                    <a href="../clubs/club-details.php?name=<?php echo urlencode($club['name']); ?>">
                        <img class="w-64 h-64 sm:w-64 sm:h-96 md:w-64 md:h-128 lg:w-128 lg:h-128 object-cover rounded-xl" src="<?php echo $club['img2']; ?>" alt="<?php echo $club['name']; ?>">
                        <img class="w-16 h-16 object-cover rounded-full absolute bottom-0 transform -translate-x-1/2 -translate-y-3/4 left-1/2" src="<?php echo $club['img3']; ?>" alt="<?php echo $club['name']; ?>">
                        <p class="text-center"><?php echo $club['name']; ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div>
        <h1>Society Clubs</h1>
        <div class="overflow-x-auto whitespace-nowrap py-4">
            <?php foreach ($societyClubs as $club) : ?>
                <div class="inline-block mx-6 relative">
                    <a href="../clubs/club-details.php?name=<?php echo urlencode($club['name']); ?>">
                        <img class="w-64 h-64 object-cover" src="<?php echo $club['img2']; ?>" alt="<?php echo $club['name']; ?>">
                        <img class="w-16 h-16 object-cover rounded-full absolute bottom-0 transform -translate-x-1/2 -translate-y-3/4 left-1/2" src="<?php echo $club['img3']; ?>" alt="<?php echo $club['name']; ?>">
                        <p class="text-center"><?php echo $club['name']; ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto text-center">
            <p>Copyright &copy; 2024 EP Tracker</p>
        </div>
    </footer>
</body>

</html>