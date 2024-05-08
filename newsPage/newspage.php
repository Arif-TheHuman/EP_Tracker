<?php
include '../db_connection.php';
$sql = "SELECT * FROM news";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <nav class="bg-blue-500 p-4 text-white fixed w-full z-50">
    <div class="container mx-auto flex items-center justify-between">
    <a class="text-lg font-semibold" href="../home/index.php">EP Tracker</a>
    <div class="flex items-center space-x-4">
        <a class="hover:text-gray-300" href="../home/index.php">Home</a>
        <a class="hover:text-gray-300" href="../clubs/club-page.php">Clubs</a>
        <a class="hover:text-gray-300" href="../newsPage/newspage.php">News</a>
        <a class="hover:text-gray-300" href="#">Calendar</a>
        <img class="h-8 w-8 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Image">
    </div>
</div>
</nav>
<div class="container mx-auto pt-16"> <!-- Kept pt-16 to make space for the fixed navbar -->
    <div class="flex justify-center items-center mb-10 mt-10"> <!-- Added mt-10 to add space at the top -->
        <h1 class="text-4xl font-bold text-center">News & Announcement</h1>
        <a href="newspage-details.php?id=1">
            <img class="w-12 h-12 ml-16" src="assets/images/frontie.png" alt="Your Avatar Description">
        </a>
    </div>
    <?php
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo '<a href="newspage-details.php?id='.$row["id"].'">
            <div class="mx-auto w-2/4 bg-center bg-cover rounded p-5 mb-5" style="background-image: url(\'assets/images/bgcard.png\');">
               <img class="w-full h-full rounded items-center object-cover" src="'.$row["image"].'" alt="Image Description">
               <p class="text-3xl font-bold mt-4 text-center">'.$row["title"].'</p>
            </div>
            </a>';
        }
    } else {
        echo "No news items found.";
    }
    ?>
</div>
</body>
</html>
<?php
mysqli_close($conn);
?>