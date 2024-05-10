<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'], $_POST['description'], $_FILES['image'])) {
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

// Handle the delete action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM news WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
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
<div class=" flex justify-center text-center mt-10 mb-10">
    <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold leading-tight text-gray-900">
        <span class="block">Add new News</span>
    </h1>
</div>
<form method="post" enctype="multipart/form-data">
    <div class="md:flex md:justify-center md:space-x-8 md:px-14">
        <div class="flex flex-col md:w-1/2">
            <label for="title" class="font-bold mb-2">Title:</label>
            <input type="text" id="title" name="title" required class="shadow-md appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="flex flex-col md:w-1/2">
            <label for="description" class="font-bold mb-2">Description:</label>
            <textarea id="description" name="description" required class="shadow-md appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
    </div>
    <div class="md:flex md:justify-center md:space-x-8 md:px-14">
        <div class="flex flex-col md:w-1/2">
            <label for="image" class="font-bold mb-2">Image:</label>
            <input type="file" id="image" name="image" required class="shadow-md appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="flex flex-col md:w-1/2">
            <input type="submit" value="Add News" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-6">
        </div>
    </div>
</form>
</div>
<div class="bg-white p-4 rounded shadow">
 <div class=" flex justify-center text-center mt-10 mb-10">
    <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold leading-tight text-gray-900">
        <span class="block">All news</span>
    </h1>
</div>
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($newsItems as $news): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $news['title']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $news['description']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $news['id']; ?>">
                            <input type="submit" name="delete" value="Delete" class="text-red-600 hover:text-red-900">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class=" flex justify-center text-center mt-10 mb-10">
    <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold leading-tight text-gray-900">
        <span class="block">Endorsed-events Details</span>
    </h1>
</div>
    <div class="mt-10">
        <?php foreach ($newsItems as $news): ?>
        <section class="bg-white p-4 rounded shadow mb-10">
            <h2 class="text-2xl font-bold mb-2"><?php echo $news['title']; ?></h2>
            <p class="text-gray-600"><?php echo $news['description']; ?></p>
            <img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>" class="w-full mt-4">
            <form method="POST" class="mt-4">
                <input type="hidden" name="id" value="<?php echo $news['id']; ?>">
                <input type="submit" name="delete" value="Delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            </form>
        </section>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>