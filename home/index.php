<?php 
include '../db_connection.php';

$ep = 40;
$percentage = round($ep / 64 * 100);
$req = 64 - $ep;
if ($ep > 64) {
    $req = 0;
}

// Fetch indoor clubs from the database
$sql = "SELECT * FROM clubs WHERE type='indoor'";
$result = $conn->query($sql);
$indoorClubs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $indoorClubs[] = $row;
    }
}

// Fetch outdoor clubs from the database
$sql = "SELECT * FROM clubs WHERE type='outdoor'";
$result = $conn->query($sql);
$outdoorClubs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $outdoorClubs[] = $row;
    }
}

// Fetch society clubs from the database
$sql = "SELECT * FROM clubs WHERE type='society'";
$result = $conn->query($sql);
$societyClubs = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $societyClubs[] = $row;
    }
}

session_start();
$username = $_SESSION['username']; // Assuming the username is stored in the session

// Fetch the 'sem' column for the logged-in user
$sql = "SELECT sem FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$sem = $row['sem'];

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
<nav class="bg-blue-500 p-4 text-white fixed w-full z-50">
    <div class="container mx-auto flex items-center justify-between">
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
<br><br><br>
<div style="background-image: url('https://i0.wp.com/boingboing.net/wp-content/uploads/2018/05/cool-background1.png?fit=930%2C468&ssl=1'); background-size: cover;" class="relative flex justify-center items-center h-64 w-3/4 bg-gray-400 mx-auto">
<a href="progress.php">
    <button class="absolute top-0 right-0 m-4 bg-transparent text-black font-bold py-2 px-4 rounded-full border-2 border-black">
        +
    </button>
</a>
    <div class="w-1/2">
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
    <div class="w-1/2 text-center">
    <h1 class="text-lg"><?php echo strtoupper($ep)?> OUT OF 64 EP</h1>
    <p class="text-lg"><?php echo $req; ?> EP REQUIRED</p>
    <p class="text-lg">SEMESTER <?php echo $sem; ?></p>
</div>
</div>
<br>
<div>
    <h1>Indoor Clubs</h1>
    <div class="overflow-x-auto whitespace-nowrap py-4">
    <?php foreach ($indoorClubs as $club) : ?>
    <div class="inline-block mx-2 relative">
        <img class="w-64 h-64 object-cover" src="<?php echo $club['img2']; ?>" alt="<?php echo $club['name']; ?>">
        <img class="w-16 h-16 object-cover rounded-full absolute bottom-0 transform -translate-x-1/2 -translate-y-3/4 left-1/2" src="<?php echo $club['img3']; ?>" alt="<?php echo $club['name']; ?>">
        <p class="text-center"><?php echo $club['name']; ?></p>
    </div>
<?php endforeach; ?>
    </div>
</div>
<div>
    <h1>Outdoor Clubs</h1>
    <div class="overflow-x-auto whitespace-nowrap py-4">
    <?php foreach ($outdoorClubs as $club) : ?>
    <div class="inline-block mx-2 relative">
        <img class="w-64 h-64 object-cover" src="<?php echo $club['img2']; ?>" alt="<?php echo $club['name']; ?>">
        <img class="w-16 h-16 object-cover rounded-full absolute bottom-0 transform -translate-x-1/2 -translate-y-3/4 left-1/2" src="<?php echo $club['img3']; ?>" alt="<?php echo $club['name']; ?>">
        <p class="text-center"><?php echo $club['name']; ?></p>
    </div>
<?php endforeach; ?>
    </div>
</div>
<div>
    <h1>Society Clubs</h1>
    <div class="overflow-x-auto whitespace-nowrap py-4">
    <?php foreach ($societyClubs as $club) : ?>
    <div class="inline-block mx-2 relative">
        <img class="w-64 h-64 object-cover" src="<?php echo $club['img2']; ?>" alt="<?php echo $club['name']; ?>">
        <img class="w-16 h-16 object-cover rounded-full absolute bottom-0 transform -translate-x-1/2 -translate-y-3/4 left-1/2" src="<?php echo $club['img3']; ?>" alt="<?php echo $club['name']; ?>">
        <p class="text-center"><?php echo $club['name']; ?></p>
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