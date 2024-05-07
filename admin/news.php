<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $target_dir = "../assets/";
    $image = $target_dir . basename($_FILES["image"]["name"]);

    // Move the uploaded file to the target directory
    move_uploaded_file($_FILES["image"]["tmp_name"], $image);

    $sql = "INSERT INTO news (title, description, image) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $description, $image);
    $stmt->execute();
}

$sql = "SELECT id, title, description, image FROM news ORDER BY id DESC";
$result = $conn->query($sql);
$newsItems = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create News</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
<div class="bg-white p-4 rounded shadow">
    <h2 class="text-2xl font-bold mb-2">Add New News</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>
        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image" required><br>
        <input type="submit" value="Add News">
    </form>
</div>
<div class="bg-white p-4 rounded shadow">
    <h2 class="text-2xl font-bold mb-2">All News</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($newsItems as $news): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $news['title']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $news['description']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>"></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>