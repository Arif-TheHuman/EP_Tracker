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
<div class="bg-white p-4 rounded shadow">
    <h2 class="text-2xl font-bold mb-2">Add New Club</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>
        <label for="type">Type:</label><br>
        <select id="type" name="type" required>
            <option value="outdoor">Outdoor</option>
            <option value="indoor">Indoor</option>
            <option value="society">Society</option>
        </select><br>
        <label for="quota">Quota:</label><br>
        <input type="number" id="quota" name="quota" required><br>
        <input type="hidden" id="img1" name="img1">
        <label for="img2">Image 2:</label><br>
        <input type="file" id="img2" name="img2" required><br>
        <label for="img3">Image 3:</label><br>
        <input type="file" id="img3" name="img3" required><br>
        <label for="profilePic">Profile Picture:</label><br>
        <input type="file" id="profilePic" name="profilePic" required><br>
        <label for="coverPic">Cover Picture:</label><br>
        <input type="file" id="coverPic" name="coverPic" required><br>
        <label for="taskbarBgImg">Taskbar Background Image:</label><br>
        <input type="file" id="taskbarBgImg" name="taskbarBgImg" required><br>
        <input type="submit" value="Add Club">
    </form>
</div>
<div class="bg-white p-4 rounded shadow">
    <h2 class="text-2xl font-bold mb-2">All Clubs</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quota</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image 2</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image 3</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile Picture</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover Picture</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taskbar Background Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($clubs as $club): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $club['name']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $club['description']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $club['type']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $club['quota']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><img src="<?php echo $club['img2']; ?>" alt="Image 2"></td>
                    <td class="px-6 py-4 whitespace-nowrap"><img src="<?php echo $club['img3']; ?>" alt="Image 3"></td>
                    <td class="px-6 py-4 whitespace-nowrap"><img src="<?php echo $club['profilePic']; ?>" alt="Profile Picture"></td>
                    <td class="px-6 py-4 whitespace-nowrap"><img src="<?php echo $club['coverPic']; ?>" alt="Cover Picture"></td>
                    <td class="px-6 py-4 whitespace-nowrap"><img src="<?php echo $club['taskbarBgImg']; ?>" alt="Taskbar Background Image"></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $club['id']; ?>">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
