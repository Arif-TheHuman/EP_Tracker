<?php
    session_start();
    include '../db_connection.php';
    $clubName = $_GET['name'];
    $sql = "SELECT * FROM clubs WHERE name='$clubName'";
    $result = mysqli_query($conn, $sql);
    $club = mysqli_fetch_assoc($result);
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
    <nav class="p-4" style="background-image: url('<?php echo $club['taskbarBgImg']; ?>'); background-size: cover;">
        <div class="container mx-auto flex items-center justify-between">
            <a class="text-lg font-semibold text-black" href="#">Club Details</a>
            <div class="flex items-center space-x-4">
                <img class="h-8 w-8 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Image">
            </div>
        </div>
    </nav>
    <br>
    <h1><?php echo $club['name']; ?></h1>
    <h2><?php echo $club['description'] ?></h2>
    <p>Members: <?php echo $club['current_members']; ?></p>
    <p>Quota: <?php echo $club['quota']; ?></p>
    <form action="join_club.php" method="post">
    <input type="hidden" name="clubId" value="<?php echo $club['id']; ?>">
    <input type="hidden" name="clubName" value="<?php echo $club['name']; ?>">
    <button type="submit">Join</button>
</form>
</body>
</html>