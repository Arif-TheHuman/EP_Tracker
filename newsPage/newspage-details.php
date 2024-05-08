<?php
include '../db_connection.php';
$newsId = $_GET['id']; // Get the news id from the URL
$sql = "SELECT * FROM news WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $newsId);
$stmt->execute();
$result = $stmt->get_result();
$newsItem = $result->fetch_assoc(); // Fetch the news item

// Check if the user has already registered
$sql = "SELECT * FROM registrations WHERE news_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $newsId);
$stmt->execute();
$result = $stmt->get_result();
$registered = $result->num_rows > 0;

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$registered) {
    // Insert a record into the registrations table
    $sql = "INSERT INTO registrations (news_id) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $newsId);
    if ($stmt->execute() !== TRUE) {
        echo "Error registering: " . $conn->error;
    }
    $registered = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $newsItem['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body  class="font-sans antialiased text-gray-900 bg-gray-100">
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
            <a href="newspage.php">
                <img class="w-12 h-12 mr-16" src="assets/images/backie.png" alt="Your Avatar Description">
            </a>
            <h1 class="text-3xl font-bold mt-4 text-center"><?php echo $newsItem['title']; ?></h1>
        </div>
        <div class="mx-auto w-3/4 bg-center bg-cover rounded p-5 mb-5" style="background-image: url('assets/images/bgcard.png');">
            <img class="w-full h-full rounded items-center object-cover" src="<?php echo $newsItem['image']; ?>" alt="News Image">
            <p class="text-3xl font-bold mt-4"><?php echo $newsItem['description']; ?></p>
        </div>
        <?php if (isset($registered) && $registered): ?>
            <div class="text-center text-green-500 text-2xl">Thank you for registering!</div>
        <?php else: ?>
            <div class="flex justify-center">
                <form method="post">
                    <button type="submit" class="bg-blue-500 text-white px-10 py-4 rounded font-bold text-xl">REGISTER NOW</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$stmt->close();
mysqli_close($conn);
?>