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

            <!-- <a href="newspage.php">
                <img class="w-12 h-12 ml-16" src="assets/images/frontie.png" alt="Your Avatar Description">
            </a> -->
        </div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $image = $_FILES['image'];
            $description = $_POST['description'];
        
            // Upload the image...
            // Assuming you have a function to handle the image upload and it returns the path to the uploaded image
            $imagePath = uploadImage($image);

            // Insert the new news item into your database...
            // Assuming you have a mysqli connection $conn
            $stmt = $conn->prepare("INSERT INTO news (title, image, description) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $imagePath, $description);
            $stmt->execute();}
        
        //new changes made for admin part possibly work??
        if ($adminRole = "admin") { // Replace this with your actual admin check
            echo '
            <div class="flex justify-center items-center">
            <h1 class="text-4xl font-bold">News & Announcement</h1>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4" onclick="document.getElementById(\'addNewsForm\').style.display=\'block\'">Add News</button>
            </div>

            <div id="addNewsForm" style="display: none;">
            <form action="" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title:</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="title" name="title">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image:</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="file" id="image" name="image">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description:</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description"></textarea>
            </div>
            <div class="flex items-center justify-between">
                <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" value="Submit">
            </div>
            </form>
            </div>
            ';
        }

        // Fetch and display all news items from the database
        $result = $conn->query("SELECT * FROM news ORDER BY id DESC");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
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


        // if (mysqli_num_rows($result) > 0) {
        //     while($row = mysqli_fetch_assoc($result)) {
        //         echo '<a href="newspage-details.php?id='.$row["id"].'">
        //         <div class="mx-auto w-2/4 bg-center bg-cover rounded p-5 mb-5" style="background-image: url(\'assets/images/bgcard.png\');">
        //            <img class="w-full h-full rounded items-center object-cover" src="'.$row["image"].'" alt="Image Description">
        //            <p class="text-3xl font-bold mt-4 text-center">'.$row["title"].'</p>
        //         </div>
        //         </a>';
        //     }
        // } else {
        //     echo "No news items found.";
        // }
        // ?>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>