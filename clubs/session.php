<?php
    include "../db_connection.php";
    $clubName = $_GET['name']; // Get the club name from the URL parameter
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

    // Fetch the club id from the "clubs" table using the club name
    $sql = "SELECT id FROM clubs WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $clubName);
    $stmt->execute();
    $result = $stmt->get_result();
    $club = $result->fetch_assoc();
    $clubId = $club['id'];

    $sql = "SELECT cs.session_date, GROUP_CONCAT(cs.time_slot) as time_slots, GROUP_CONCAT(us.attendance_status) as attendance_statuses
        FROM club_sessions cs 
        LEFT JOIN user_sessions us ON cs.id = us.session_id AND us.user_id = ?
        WHERE cs.club_id = ?
        GROUP BY cs.session_date";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $clubId);
$stmt->execute();
$result = $stmt->get_result();
$sessions = $result->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT name FROM clubs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clubId);
    $stmt->execute();
    $result = $stmt->get_result();
    $club = $result->fetch_assoc();
    $clubName = $club['name'];
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-montserrat bg-gray-100">
    <div class="w-full h-70 bg-cover bg-center" style="background-image: url(../assets/figmatingy1.jpg);">'
    <div id="session" class="font-bold flex items-center justify-center text-black"><h5 id="session">SESSION</h5></div>
    </div>'
    <a href="club-details.php?name=<?php echo urlencode($clubName); ?>">Back to Club Details</a>
    
    <table class="table-auto w-full mt-10 mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <thead>
            <tr>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Time Slot</th>
                <th class="px-4 py-2">Attendance Status</th>
            </tr>
        </thead>
        <tbody>
        <?php 
$total_time_slots = array_sum(array_map(function($session) {
    return count(explode(',', $session['time_slots']));
}, $sessions));
$current_time_slot = 0;
foreach ($sessions as $session): 
    $time_slots = isset($session['time_slots']) ? explode(',', $session['time_slots']) : [];
    for ($i = 0; $i < count($time_slots); $i++, $current_time_slot++): ?>
        <tr>
            <td class="border px-4 py-2"><?php echo $session['session_date']; ?></td>
            <td class="border px-4 py-2"><?php echo $time_slots[$i]; ?></td>
            <td class="border px-4 py-2">
                <?php 
                if ($current_time_slot < $total_time_slots * 0.7) { // 70% of the total time slots
                    echo 'Present';
                } elseif ($current_time_slot < $total_time_slots * 0.9) { // Next 20% of the total time slots
                    echo 'Absent';
                } else { // Last 10% of the total time slots
                    echo 'Submit';
                }
                ?>
            </td>
        </tr>
    <?php endfor; endforeach; ?>
        </tbody>
    </table>
</body>
</html>