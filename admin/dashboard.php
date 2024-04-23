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
        $sql = "INSERT INTO clubs (name, description, type, quota, img1, img2, img3, profilePic, coverPic, taskbarBgImg) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiisssss", $_POST['name'], $_POST['description'], $_POST['type'], $_POST['quota'], $_POST['img1'], $_POST['img2'], $_POST['img3'], $_POST['profilePic'], $_POST['coverPic'], $_POST['taskbarBgImg']);
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
    <form method="POST">
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
        <input type="text" id="img1" name="img1" required><br>
        <label for="img2">Image 2:</label><br>
        <input type="text" id="img2" name="img2" required><br>
        <label for="img3">Image 3:</label><br>
        <input type="text" id="img3" name="img3" required><br>
        <label for="profilePic">Profile Picture:</label><br>
        <input type="text" id="profilePic" name="profilePic" required><br>
        <label for="coverPic">Cover Picture:</label><br>
        <input type="text" id="coverPic" name="coverPic" required><br>
        <label for="taskbarBgImg">Taskbar Background Image:</label><br>
        <input type="text" id="taskbarBgImg" name="taskbarBgImg" required><br>
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
            <td><?php echo $club['img1']; ?></td>
            <td><?php echo $club['img2']; ?></td>
            <td><?php echo $club['img3']; ?></td>
            <td><?php echo $club['profilePic']; ?></td>
            <td><?php echo $club['coverPic']; ?></td>
            <td><?php echo $club['taskbarBgImg']; ?></td>
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