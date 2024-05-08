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
<body class="bg-gray-100">
    <div class="p-10 flex justify-between items-center bg-center bg-cover" style="background-image: url('assets/images/head.png');">
        <img class="w-24 h-24 rounded-full" src="assets/images/ronaldo.png" alt="Your Avatar Description">
    </div>
    <div class="container mx-auto my-10">
        <div class="flex justify-center items-center mb-10">
            <h1 class="text-4xl font-bold text-center">News & Announcement</h1>
            <a href="EP_Hub.php">
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