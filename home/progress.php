<?php 
session_start(); // Start the session
include '../db_connection.php';
if (isset($_SESSION['user']['username'])) {
    $username = $_SESSION['user']['username']; // Set the $username variable
} else {
    echo "Username is not set in the session";
    exit(); // Stop the script if the username is not set in the session
}
$sem = isset($_POST['sem']) ? $_POST['sem'] + 1 : 1; // Get the semester from POST data or default to 1
// Fetch user data
$sql = "SELECT id, sem, ep FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$userId = $row['id'];
// Fetch all the events for the current semester that the user has participated in
$sql = "SELECT events.*, user_events.sem as user_sem FROM events 
        JOIN user_events ON events.id = user_events.event_id 
        WHERE user_events.user_id = ? AND user_events.sem = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $sem);
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<nav class="bg-blue-500 p-4 text-white fixed w-full z-50">
    <div class="container mx-auto flex items-center justify-between">
    <button onclick="location.href='index.php'" class="m-4 bg-transparent text-white font-bold py-2 px-4 rounded-full border-2 border-white hover:bg-white hover:text-blue-500">
        Back
    </button>
        <a class="text-lg font-semibold" href="#">EP Tracker</a>
        <div class="flex items-center space-x-4">
            <a class="hover:text-gray-300" href="#">Home</a>
            <a class="hover:text-gray-300" href="../clubs/club-page.php">Clubs</a>
            <a class="hover:text-gray-300" href="../newsPage/newspage.php">News</a>
            <a class="hover:text-gray-300" href="#">Calendar</a>
            <img class="h-8 w-8 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Image">
        </div>
    </div>
</nav>
<br><br>
<div class="mt-16">
    <div class="container mx-auto flex justify-center items-center h-64 w-3/4 sm:w-3/5 md:w-3/4 lg:w-4/5 bg-gray-400 rounded-xl" style="background-image: url('../assets/homerectangle.png'); background-size: cover; background-repeat: no-repeat;">
        <svg class="w-64 h-64 mx-auto" viewBox="0 0 36 36">
            <path class="circle-bg"
                d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"
                fill="none"
                stroke="#eee"
                stroke-width="2.5"
                />
            <path class="circle"
                stroke="#4c51bf"
                stroke-dasharray="<?php echo $percentage; ?>, 100"
                d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"
                fill="none"
                stroke-width="2.5"
                stroke-linecap="round"
                />
                <text x="18" y="18" class="percentage" fill="#4c51bf" text-anchor="middle" dy=".3em" font-size="8"><?php echo $percentage; ?>%</text>
        </svg>
        </div>
        
<div class="container mx-auto text-center my-8">
    <h1 class="text-2xl sm:ml-40 lg:ml-64 md:ml-48 font-bold p-2 bg-blue-500 text-white rounded-lg w-1/2"><?php echo strtoupper($totalAllEP)?> OUT OF 64 EP</h1>
    <p class="text-lg sm:ml-40 lg:ml-64 md:ml-48 p-2 bg-red-500 text-white w-1/2 rounded-lg"><?php echo $req; ?> EP REQUIRED!!</p>
    <div class="flex justify-center items-center space-x-4">
    <form method="POST">
        <input type="hidden" name="sem" value="<?php echo $sem - 2; ?>">
        <button type="submit" class="m-4 hover:text-gray-600 hover:bg-gray-900 bg-transparent text-black font-bold py-2 px-4 rounded-full border-2 border-black  <?php echo $sem <= 1 ? 'opacity-0' : ''; ?>" <?php echo $sem <= 1 ? 'disabled' : ''; ?>>
            <
        </button>
    </form>
    <p class="text-lg text-gray-700">SEMESTER <?php echo $sem; ?></p>
    <form method="POST">
        <input type="hidden" name="sem" value="<?php echo $sem; ?>">
        <button type="submit" class="m-4 hover:text-gray-600 hover:bg-gray-900 bg-transparent text-black font-bold py-2 px-4 rounded-full border-2 border-black <?php echo $sem >= 6 ? 'opacity-0' : ''; ?>" <?php echo $sem >= 6 ? 'disabled' : ''; ?>>
            >
        </button>
    </form>
</div>
</div>
    <div class="container mx-auto my-4">
    <table class="table-auto mx-auto">
    <thead>
    <tr>
        <th class="px-4 py-2">Event Name</th>
        <th class="px-4 py-2">Description</th>
        <th class="px-4 py-2">Date</th>
        <th class="px-4 py-2">EP</th>
        <th class="px-4 py-2">Semester</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($events as $event): ?>
    <tr>
        <td class="border px-4 py-2"><?php echo $event['name']; ?></td>
        <td class="border px-4 py-2"><?php echo $event['description']; ?></td>
        <td class="border px-4 py-2"><?php echo $event['date']; ?></td>
        <td class="border px-4 py-2"><?php echo $event['ep']; ?></td>
        <td class="border px-4 py-2"><?php echo $event['user_sem']; ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
    </table>
    <form method="POST">
    <input type="hidden" name="sem" value="<?php echo $sem; ?>">
</form>
</div>
</div>
</body>
</html>