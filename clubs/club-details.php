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
            <a href="../clubs/club-page.php" class="text-3xl bg-white rounded-full p-2">Back</a>
        </div>
        <h1 class="text-white text-lg"></h1>
        <div onclick="window.location.href='../profile/profile.php'" class="bg-white rounded-full">
            <img class="w-24 h-24 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Picture">
        </div>
    </header>


    <br>
    <!-- this will be the background image for the content -->
    <div style="background-image: url('<?php echo $club['bgforcontent']; ?>'); background-size: cover;">
    <div class="flex items-center justify-center xl:justify-start">
        <a href="club-page.php">
            <img class="mr-16 mt-10 w-12 h-12 xl:ml-32 xl:mr-8" src="assets/images/backaru.png" alt="Your Avatar Description">
        </a>
        <h1 class="mr-24 font-semibold mt-10 text-4xl xl:font-bold"><?php echo $club['name']; ?></h1>
    </div>

    <div class="mt-12 flex flex-col items-center xl:flex-row xl:items-start xl:space-x-96 xl:justify-center">
        <div>
            <img class="w-72 h-72 object-cover rounded-full xl:mb-16 xl:w-36 xl:h-36" src="<?php echo $club['img3']; ?>" alt="Club Image">
        </div>
        <div>
            <p class="font-semibold text-3xl text-center mt-12 items-center xl:font-bold"><?php echo $club['current_members']; ?><br>Members</p>
        </div>
        <div>
            <p class="font-semibold text-3xl text-center mt-12 mb-12 xl:font-bold"><?php echo $club['quota']; ?><br>Quota</p>
        </div>
    </div>

    <?php if (!$isMember) : ?>
<form action="join_club.php" method="post" class="pb-4">
    <input type="hidden" name="clubId" value="<?php echo $club['id']; ?>">
    <input type="hidden" name="clubName" value="<?php echo $club['name']; ?>">
    <div class="flex justify-center items-center">
        <button class="mb-12 text-3xl bg-white hover:bg-gray-200 text-black font-bold py-2 px-4 rounded" type="submit">Join</button>
    </div>            
</form>
<?php else : ?>
<div class="flex justify-center items-center space-x-4 pb-4">
    <form action="leave_club.php" method="post">
        <input type="hidden" name="clubId" value="<?php echo $club['id']; ?>">
        <input type="hidden" name="clubName" value="<?php echo $club['name']; ?>">
        <button class="mb-12 text-3xl bg-white hover:bg-gray-200 text-black font-bold py-2 px-4 rounded" type="submit">Joined</button>
    </form>
    <a href="session.php?name=<?php echo urlencode($club['name']); ?>" class="mb-12 text-3xl bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Session</a>
    <form action="leave_club.php" method="post">
        <input type="hidden" name="clubId" value="<?php echo $club['id']; ?>">
        <input type="hidden" name="clubName" value="<?php echo $club['name']; ?>">
        <button type="submit" class="mb-12 text-3xl bg-white hover:bg-gray-200 text-black font-bold py-2 px-4 rounded">Leave</button>
    </form>
</div>
<?php endif; ?>
</div>

    <div class="flex flex-col items-center justify-center">
    <img class="w-3/4 h-auto object-cover rounded-xl shadow-md mt-8 xl:w-2/3" src="<?php echo $club['contentNO1']; ?>" alt="Club Image">
    <img class="w-3/4 h-auto object-cover rounded-xl shadow-md mt-8 xl:w-2/3" src="<?php echo $club['contentNO2']; ?>" alt="Club Image">
    <img class="w-3/4 h-auto object-cover rounded-xl shadow-md mt-8 mb-6 xl:w-2/3" src="<?php echo $club['contentNO3']; ?>" alt="Club Image">
</div>
    
    <form action="join_club.php" method="post">
        <input type="hidden" name="clubId" value="<?php echo $club['id']; ?>">
        <input type="hidden" name="clubName" value="<?php echo $club['name']; ?>">
    </form>

</body>

</html>