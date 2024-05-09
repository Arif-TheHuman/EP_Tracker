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
    
$clubId = $_GET['clubId'];
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