<?php
include '../db_connection.php';
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get all clubs
$sql = "SELECT * FROM clubs";
$result = $conn->query($sql);
$clubs = $result->fetch_all(MYSQLI_ASSOC);

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add a new club
    $target_dir = "../assets/";
    $img1 = isset($_FILES["img1"]["name"]) ? $target_dir . basename($_FILES["img1"]["name"]) : 0;
    $img2 = $target_dir . basename($_FILES["img2"]["name"]);
    $img3 = $target_dir . basename($_FILES["img3"]["name"]);
    $profilePic = $target_dir . basename($_FILES["profilePic"]["name"]);
    $coverPic = $target_dir . basename($_FILES["coverPic"]["name"]);
    $taskbarBgImg = $target_dir . basename($_FILES["taskbarBgImg"]["name"]);
    // Move the uploaded files to the target directory
    move_uploaded_file($_FILES["img2"]["tmp_name"], $img2);
    move_uploaded_file($_FILES["img3"]["tmp_name"], $img3);
    move_uploaded_file($_FILES["profilePic"]["tmp_name"], $profilePic);
    move_uploaded_file($_FILES["coverPic"]["tmp_name"], $coverPic);
    move_uploaded_file($_FILES["taskbarBgImg"]["tmp_name"], $taskbarBgImg);
    $sql = "INSERT INTO clubs (name, description, type, quota, img1, img2, img3, profilePic, coverPic, taskbarBgImg) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiisssss", $_POST['name'], $_POST['description'], $_POST['type'], $_POST['quota'], $img1, $img2, $img3, $profilePic, $coverPic, $taskbarBgImg);
    $stmt->execute();
}
// Close the connection

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="window.location.href='dashboard.php'">Back to Dashboard</button>

<div class=" flex justify-center text-center mt-10 mb-10">
    <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold leading-tight text-gray-900">
        <span class="block">Add new clubs</span>
    </h1>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-bold mb-2">Name</h2>
        <input type="text" class="w-full bg-gray-200 hover:bg-gray-400 rounded-xl" id="name" name="name" required>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-bold mb-2">Description</h2>
        <textarea class="w-full bg-gray-200 hover:bg-gray-400 rounded-sm" id="description" name="description" required></textarea>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-bold mb-2">Type</h2>
        <select class="w-full" id="type" name="type" required>
            <option value="outdoor">Outdoor</option>
            <option value="indoor">Indoor</option>
            <option value="society">Society</option>
        </select>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-bold mb-2 ">Quota</h2>
        <input type="number" class="w-full bg-gray-200 hover:bg-gray-400 rounded-sm" id="quota" name="quota" required>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-bold mb-2">Image 2</h2>
        <input type="file" id="img2" name="img2" required>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-bold mb-2">Image 3</h2>
        <input type="file" id="img3" name="img3" required>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-bold mb-2">Profile Picture</h2>
        <input type="file" id="profilePic" name="profilePic" required>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-bold mb-2">Cover Picture</h2>
        <input type="file" id="coverPic" name="coverPic" required>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-bold mb-2">Taskbar Background Image</h2>
        <input type="file" id="taskbarBgImg" name="taskbarBgImg" required>
    </div>
</div>

<div class=" flex justify-center text-center mt-10">
    <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold leading-tight text-gray-900">
        <span class="block">Club Details</span>
    </h1>
</div>

<div class="flex flex-wrap -mx-4 mt-10">
    <?php foreach ($clubs as $club): ?>
    <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-4">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center">
                    <div class="text-xl font-bold text-gray-900"><?php echo $club['name']; ?></div>
                </div>
                <div>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $club['id']; ?>">
                        <input type="submit" name="delete" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    </form>
                </div>
            </div>
            <div class="px-6 py-4">
                <p class="text-gray-700 text-xl"><b>Club Description: </b><?php echo $club['description']; ?></p>
            </div>
            <div class="px-6 py-4">
                <span class="text-gray-700 text-xl"><b>Type: </b><?php echo $club['type']; ?></span>
            </div>
            <div class="px-6 py-4">
                <span class="text-gray-700 text-xl"><b>Quota: </b><?php echo $club['quota']; ?></span>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="px-6 py-4">
                    <img src="<?php echo $club['img2']; ?>" alt="Image 2" class="w-32 h-32 object-cover">
                </div>
                <div class="px-6 py-4">
                    <img src="<?php echo $club['img3']; ?>" alt="Image 3" class="w-32 h-32 object-cover">
                </div>
                <div class="px-6 py-4">
                    <img src="<?php echo $club['profilePic']; ?>" alt="Profile Picture" class="w-32 h-32 object-cover">
                </div>
                <div class="px-6 py-4">
                    <img src="<?php echo $club['coverPic']; ?>" alt="Cover Picture" class="w-32 h-32 object-cover">
                </div>
                <div class="px-6 py-4">
                    <img src="<?php echo $club['taskbarBgImg']; ?>" alt="Taskbar Background Image" class="w-32 h-32 object-cover">
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
</body>
</html>
