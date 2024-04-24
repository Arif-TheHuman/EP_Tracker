<?php
include '../db_connection.php';

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        // Delete the club
        $sql = "DELETE FROM clubs WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
    } else {
        // Add a new club
        $target_dir = "../assets/";
        $img1 = $target_dir . basename($_FILES["img1"]["name"]);
        $img2 = $target_dir . basename($_FILES["img2"]["name"]);
        $img3 = $target_dir . basename($_FILES["img3"]["name"]);
        $profilePic = $target_dir . basename($_FILES["profilePic"]["name"]);
        $coverPic = $target_dir . basename($_FILES["coverPic"]["name"]);
        $taskbarBgImg = $target_dir . basename($_FILES["taskbarBgImg"]["name"]);

        // Move the uploaded files to the target directory
        move_uploaded_file($_FILES["img1"]["tmp_name"], $img1);
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
}

// Get all clubs
$sql = "SELECT * FROM clubs";
$result = $conn->query($sql);
$clubs = $result->fetch_all(MYSQLI_ASSOC);

// Close the connection
$conn->close();
?>

<!-- HTML for the admin dashboard goes here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>Add New Club</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>
        <label for="type">Type:</label><br>
        <select id="type" name="type" required>
            <option value="outdoor">Outdoor</option>
            <option value="indoor">Indoor</option>
        </select><br>
        <label for="quota">Quota:</label><br>
        <input type="number" id="quota" name="quota" required><br>
        <label for="img1">Image 1:</label><br>
        <input type="file" id="img1" name="img1" required><br>
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

    <h2>All Clubs</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Type</th>
            <th>Quota</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($clubs as $club): ?>
        <tr>
            <td><?php echo $club['name']; ?></td>
            <td><?php echo $club['description']; ?></td>
            <td><?php echo $club['type']; ?></td>
            <td><?php echo $club['quota']; ?></td>
            <td><img src="<?php echo $club['img2']; ?>" alt="Image 2"></td>
            <td><img src="<?php echo $club['img3']; ?>" alt="Image 3"></td>
            <td><img src="<?php echo $club['profilePic']; ?>" alt="Profile Picture"></td>
            <td><img src="<?php echo $club['coverPic']; ?>" alt="Cover Picture"></td>
            <td><img src="<?php echo $club['taskbarBgImg']; ?>" alt="Taskbar Background Image"></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $club['id']; ?>">
                    <input type="submit" name="delete" value="Delete">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>