<?php 
include '../db_connection.php';
$username = 'UserMan';
$sem = isset($_POST['sem']) ? $_POST['sem'] + 1 : 1; // Get the semester from POST data or default to 1

// Fetch user data
$sql = "SELECT id, sem, ep FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$userId = $row['id'];
$ep = $row['ep'];
$percentage = round($ep / 64 * 100);
$req = 64 - $ep;
if ($ep > 64) {
    $req = 0;
}

// Fetch all the events for the current semester
$sql = "SELECT * FROM events WHERE sem = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $sem);
$stmt->execute();
$result = $stmt->get_result();
$events = $result->fetch_all(MYSQLI_ASSOC);
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
    <button onclick="location.href='index.php'" class="m-4 bg-transparent text-white font-bold py-2 px-4 rounded-full border-2 border-white">
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
    <div class="container mx-auto flex justify-center items-center h-64 w-3/4 bg-gray-400">
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
    <h1 class="text-2xl font-bold"><?php echo strtoupper($ep)?> OUT OF 64 EP</h1>
    <p class="text-lg text-gray-700"><?php echo $req; ?> EP REQUIRED</p>
    <div class="flex justify-center items-center space-x-4">
    <form method="POST">
        <input type="hidden" name="sem" value="<?php echo $sem - 2; ?>">
        <button type="submit" class="m-4 bg-transparent text-black font-bold py-2 px-4 rounded-full border-2 border-black <?php echo $sem <= 1 ? 'opacity-0' : ''; ?>" <?php echo $sem <= 1 ? 'disabled' : ''; ?>>
            <
        </button>
    </form>
    <p class="text-lg text-gray-700">SEMESTER <?php echo $sem; ?></p>
    <form method="POST">
        <input type="hidden" name="sem" value="<?php echo $sem; ?>">
        <button type="submit" class="m-4 bg-transparent text-black font-bold py-2 px-4 rounded-full border-2 border-black <?php echo $sem >= 6 ? 'opacity-0' : ''; ?>" <?php echo $sem >= 6 ? 'disabled' : ''; ?>>
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
        <th class="px-4 py-2">Semester</th> <!-- New column for semester -->
    </tr>
</thead>
<tbody>
    <?php foreach ($events as $event): ?>
    <tr>
        <td class="border px-4 py-2"><?php echo $event['name']; ?></td>
        <td class="border px-4 py-2"><?php echo $event['description']; ?></td>
        <td class="border px-4 py-2"><?php echo $event['date']; ?></td>
        <td class="border px-4 py-2"><?php echo $event['ep']; ?></td>
        <td class="border px-4 py-2"><?php echo $event['sem']; ?></td> <!-- Display the semester -->
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