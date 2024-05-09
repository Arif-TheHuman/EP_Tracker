<?php
    include "../db_connection.php";
    $clubId = $_GET['clubId'];
    session_start();
    if (isset($_SESSION['user']['username'])) {
        $username = $_SESSION['user']['username']; // Set the $username variable
    } else {
        echo "Username is not set in the session";
        exit(); // Stop the script if the username is not set in the session
    }
    // Fetch the user id from the "users" table using the username
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $userId = $user['id'];
    // Now you can use $userId in your next query
    $sql = "SELECT cs.*, us.attendance_status FROM club_sessions cs 
            LEFT JOIN user_sessions us ON cs.id = us.session_id 
            WHERE cs.club_id = ? AND us.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $clubId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $sessions = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body class="font-montserrat">
    <div class="absolute top-0 left-0 w-full h-10 bg-cover" style="background-image: url(./assets/figmatingy1.jpg);">
        <button id="back" class="ml-2 text-transparent bg-transparent">
            <img src="./assets/arrow.png" alt="Image">
        </button>
        <div id="session" class="font-bold flex items-center justify-center"><h5 id="session">SESSION</h5></div>
    </div>
    <div class="absolute top-10 left-0 w-full h-10 bg-cover" style="background-image: url(./assets/figmating2.png);"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-9/10 h-1 bg-blue-500 flex items-center justify-between">
        <div class="date">Date</div>  
        <div class="submit">Submit</div>
    </div>
    <?php
// Dummy data
$dummyData = [
    ['date' => '2024-04-24', 'submitted' => true],
    ['date' => '2024-04-25', 'submitted' => false],
    ['date' => '2024-04-26', 'submitted' => true],
    // Add more dummy data as needed
];
foreach ($dummyData as $data) {
    $date = $data['date'];
    $submitted = $data['submitted'];
    // Check if date data exists
    if (!empty($date)) {
        // Display custom rectangle with date and submitted status
        echo '<div class="bg-gray-200 p-2 rounded-md">';
        echo '<div class="flex items-center justify-between">';
        echo '<div class="text-left font-bold">' . $date . '</div>';
        echo '<div class="text-right font-bold">Submitted: ' . ($submitted ? 'Yes' : 'No') . '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>
    
    <table class="table-auto">
        <thead>
            <tr>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Time Slot</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($sessions as $session): ?>
        <tr>
            <td class="border px-4 py-2"><?php echo $session['session_date']; ?></td>
            <td class="border px-4 py-2"><?php echo $session['time_slot'];?></td>
            <td class="border px-4 py-2"><?php echo $session['attendance_status'];?></td>
        </tr>
    <?php endforeach; ?>
</tbody>
    </table>

</body>
</html>