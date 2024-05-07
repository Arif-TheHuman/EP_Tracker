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
    }
}
// Get all clubs
$sql = "SELECT * FROM clubs";
$result = $conn->query($sql);
$clubs = $result->fetch_all(MYSQLI_ASSOC);
// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-4">Admin Dashboard</h1>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <a href="createClub.php" class="text-white no-underline">Create Club</a>
    </button>
</div>
</body>
</html>