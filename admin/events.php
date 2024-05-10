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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
<div class=" flex justify-center text-center mt-10 mb-10">
    <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold leading-tight text-gray-900">
        <span class="block">Add New Events</span>
    </h1>
</div>

<body class="bg-gray-100">


    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-lg p-8 flex flex-col md:flex-row flex-wrap md:flex-no-wrap">
            <form class="w-full md:w-1/2 p-2" method="post">
                <div class="flex flex-col">
                    <input class="w-full p-2 border rounded" type="text" name="name" placeholder="Name">
                </div>
                <div class="flex flex-col mt-4">
                    <input class="w-full p-2 border rounded" type="text" name="ep" placeholder="EP">
                </div>
            </form>
            <form class="w-full md:w-1/2 p-2" method="post">
                <div class="flex flex-col">
                    <textarea class="w-full p-2 border rounded" name="description" placeholder="Description"></textarea>
                </div>
                <div class="flex flex-col mt-4">
                    <input class="w-full p-2 border rounded" type="text" name="date" placeholder="Date">
                </div>
                <div class="flex flex-col mt-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Create</button>
                </div>
            </form>
        </div>
    </div>

    <div class=" flex justify-center text-center mt-10 mb-10">
        <h1 class="text-3xl sm:text-5xl md:text-6xl font-bold leading-tight text-gray-900">
            <span class="block">List of Events</span>
        </h1>
    </div>

    <div class="flex flex-wrap -mx-2">
        <?php foreach ($events as $event) : ?>
            <div class="w-full p-2 md:w-1/2 lg:w-1/3 xl:w-1/4">
                <div class="bg-white rounded-lg shadow-lg p-4 flex flex-col">
                    <div class="flex justify-between">
                        <h3 class="text-lg font-bold"><?php echo $event['name']; ?></h3>
                        <form method="post">
                            <input type="hidden" name="delete" value="<?php echo $event['id']; ?>">
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                    <p class="mt-2"><?php echo $event['date']; ?></p>
                    <p class="mt-2"><?php echo $event['description']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>