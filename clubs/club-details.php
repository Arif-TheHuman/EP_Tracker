<?php
session_start();
include '../db_connection.php';
$userId = $_SESSION['user']['id']; // Get userId from session
$clubName = $_GET['name'];
$sql = "SELECT * FROM clubs WHERE name='$clubName'";
$result = mysqli_query($conn, $sql);
$club = mysqli_fetch_assoc($result);

// Check if user is already a member of the club
$sql = "SELECT * FROM user_clubs WHERE user_id=$userId AND club_id={$club['id']}";
$result = mysqli_query($conn, $sql);
$isMember = mysqli_num_rows($result) > 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <!-- Taskbar -->
    <header class="p-6 flex justify-between items-center bg-cover" style="background-image: url('<?php echo $club['headnav']; ?>'); position: relative;">
        <div class="back-button">
            <a href="../clubs/club-page.php" class="bg-white rounded-full p-2">Back</a>
        </div>
        <h1 class="text-white text-lg"></h1>
        <div onclick="window.location.href='../profile/profile.php'" class="bg-white rounded-full">
            <img class="w-12 h-12 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Picture">
        </div>
    </header>


    <br>
    <!-- this will be the background image for the content -->
    <div style="background-image: url('<?php echo $club['bgforcontent']; ?>'); background-size: cover;">
        <div class="flex items-center">
            <a href="club-page.php">
                <img class="mt-10 w-12 h-12 ml-32 mr-8" src="assets/images/backie.png" alt="Your Avatar Description">
            </a>
            <h1 class=" font-semibold mt-10 text-4xl"><?php echo $club['name']; ?></h1>
        </div>

        <div class="flex space-x-10 mt-8">
            <div>
                <img class="mb-16 ml-64 w-36 h-36 object-cover rounded-full" src="<?php echo $club['img3']; ?>" alt="Club Image">
            </div>
            <div>
                <p class="ml-96 font-semibold text-3xl text-center mt-12 items-center"><?php echo $club['current_members']; ?><br>Members</p>
            </div>
            <div>
                <p class="ml-96 font-semibold text-3xl text-center mt-12"><?php echo $club['quota']; ?><br>Quota</p>
            </div>
        </div>

        <?php if (!$isMember) : ?>
            <form action="join_club.php" method="post" class="pb-4">
                <input type="hidden" name="clubId" value="<?php echo $club['id']; ?>">
                <input type="hidden" name="clubName" value="<?php echo $club['name']; ?>">
                <button class="bg-white hover:bg-gray-200 text-black font-bold py-2 px-4 rounded" type="submit">Join</button>
            </form>
        <?php else : ?>
            <div class="flex items-center space-x-4 pb-4">
                <form action="leave_club.php" method="post">
                    <input type="hidden" name="clubId" value="<?php echo $club['id']; ?>">
                    <input type="hidden" name="clubName" value="<?php echo $club['name']; ?>">
                    <button class="bg-white hover:bg-gray-200 text-black font-bold py-2 px-4 rounded" type="submit">Joined</button>
                </form>
                <a href="session.php?clubId=<?php echo $club['id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Session</a>
                <form action="leave_club.php" method="post">
                    <input type="hidden" name="clubId" value="<?php echo $club['id']; ?>">
                    <input type="hidden" name="clubName" value="<?php echo $club['name']; ?>">
                    <button type="submit" class="bg-white hover:bg-gray-200 text-black font-bold py-2 px-4 rounded">Leave</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <img src="<?php echo $club['contentNO1']; ?>" alt="Club Image">
    <img src="<?php echo $club['contentNO2']; ?>" alt="Club Image">
    <img src="<?php echo $club['contentNO3']; ?>" alt="Club Image">
    
    <form action="join_club.php" method="post">
        <input type="hidden" name="clubId" value="<?php echo $club['id']; ?>">
        <input type="hidden" name="clubName" value="<?php echo $club['name']; ?>">
    </form>

</body>

</html>