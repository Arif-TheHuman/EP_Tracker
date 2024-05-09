<?php
include "../db_connection.php";

// Insert data into database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['date']) && isset($_POST['ep'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $ep = $_POST['ep'];

    $sql = "INSERT INTO events (name, description, date, ep) VALUES ('$name', '$description', '$date', '$ep')";

    if ($conn->query($sql) !== TRUE) {
        echo "Error inserting record: " . $conn->error;
    }
}

// Delete data from database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete']) && is_numeric($_POST['delete'])) {
    $id = $_POST['delete'];

    $sql = "DELETE FROM events WHERE id = $id";

    if ($conn->query($sql) !== TRUE) {
        echo "Error deleting record: " . $conn->error;
    }
}

// Get data from database
$sql = "SELECT * FROM events ORDER BY date"; // The error is that the SELECT statement is missing the column names. The solution is to add "SELECT id, name, description, date, ep, sem" before the FROM clause.
$result = $conn->query($sql);

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post">
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="description" placeholder="Description">
        <input type="text" name="date" placeholder="Date">
        <input type="text" name="ep" placeholder="EP">
        <button type="submit">Create</button>
    </form>

    <?php foreach ($events as $event) : ?>
        <p>
            <?php echo $event['date'] . ': ' . $event['name']; ?>
            <form method="post">
                <input type="hidden" name="delete" value="<?php echo $event['id']; ?>">
                <button type="submit">Delete</button>
            </form>
        </p>
    <?php endforeach; ?>
</body>

</html>