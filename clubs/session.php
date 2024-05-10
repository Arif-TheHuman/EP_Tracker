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

$sql = "SELECT cs.session_date, cs.attendance, GROUP_CONCAT(cs.time_slot) as time_slots
    FROM club_sessions cs 
    WHERE cs.club_id = ?
    GROUP BY cs.session_date, cs.attendance";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clubId);
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
    <header class="p-6 flex justify-between items-center bg-cover" style="background-image: url('../calendar/assets/background.jpg'); position: relative;">
        <div class="back-button">
            <a href="club-details.php?name=<?php echo urlencode($clubName); ?>" class="m-4 bg-transparent text-white font-bold py-2 px-4 rounded-full border-2 border-white hover:bg-white hover:text-blue-500">Back</a>
        </div>
        <h1 class="text-white text-lg"></h1>
        <div onclick="window.location.href='../profile/profile.php'" class="bg-white rounded-full">
            <img class="w-12 h-12 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Picture">
        </div>
    </header>

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
            $total_sessions = count($sessions);
            $current_session = 0;
            $current_time_slot = 0;
            $first_none = true;
            foreach ($sessions as $session) :
                $time_slots = isset($session['time_slots']) ? explode(',', $session['time_slots']) : [];
                for ($i = 0; $i < count($time_slots); $i++, $current_time_slot++) : ?>
                    <tr>
                        <td class="border px-4 py-2"><?php echo $session['session_date']; ?></td>
                        <td class="border px-4 py-2"><?php echo $time_slots[$i]; ?></td>
                        <td class="border px-4 py-2">
                            <?php
                            if ($current_session >= $total_sessions - 2) {
                                if ($first_none) {
                                    if (isset($_SESSION['attendance_status']) && $_SESSION['attendance_status'] == 'Present') {
                                        echo 'Present';
                                    } else {
                                        echo '<a href="sessionpassword.php?name=' . urlencode($clubName) . '">Submit</a>';
                                    }
                                    $first_none = false;
                                } else {
                                    echo '-';
                                }
                            } else {
                                echo $session['attendance'];
                            }
                            ?>
                        </td>
                    </tr>
            <?php endfor;
                $current_session++;
            endforeach; ?>
        </tbody>
    </table>
</body>

</html>