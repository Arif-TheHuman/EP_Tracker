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

<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <header class="p-6 flex justify-between items-center bg-cover" style="background-image: url('../calendar/assets/background.jpg'); position: relative;">
        <div class="back-button">
            <a href="newspage.php" class="m-4 bg-transparent text-white font-bold py-2 px-4 rounded-full border-2 border-white hover:bg-white hover:text-blue-500">Back</a>
        </div>
        <h1 class="text-white text-lg"></h1>
        <div onclick="window.location.href='../profile/profile.php'" class="bg-white rounded-full">
            <img class="w-12 h-12 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Picture">
        </div>
    </header>

    <div class="container mx-auto pt-16"> <!-- Kept pt-16 to make space for the fixed navbar -->
        <div class="flex justify-center items-center mb-10 mt-10">
            <a href="newspage.php">
                <img class="w-12 h-12 mr-4" src="assets/images/backaru.png" alt="Your Avatar Description">
            </a>
            <h1 class="text-4xl font-bold mt-4 text-center"><?php echo $newsItem['title']; ?></h1>
        </div>
        <!-- <div class="mx-auto w-3/4 bg-center bg-cover rounded p-5 mb-5" style="background-image: url('assets/images/bgcard.png');"> -->
        <img class="w-full h-full rounded items-center object-cover" src="<?php echo $newsItem['image']; ?>" alt="News Image">
        <p class="text-5xl font-bold mt-4"><?php echo $newsItem['description']; ?></p>
    </div>
    <?php if (isset($registered) && $registered) : ?>
        <div class="text-center text-green-500 text-2xl">Thank you for registering!</div>
    <?php else : ?>
        <div class="flex justify-center">
            <form method="post">
                <button type="submit" class="mt-10 mb-10 bg-blue-500 text-white px-10 py-4 rounded font-bold text-xl tracking-widest">REGISTER NOW</button>
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