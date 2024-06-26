<?php
session_start();
include "../db_connection.php";
$stmt = $conn->prepare("SELECT * FROM events WHERE date >= CURDATE() ORDER BY date ASC LIMIT 3");
$stmt->execute();
$result = $stmt->get_result();
$events = $result->fetch_all(MYSQLI_ASSOC);
if (empty($events)) {
    echo "No events found.";
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['registered'][$_POST['event_id']] = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EP Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <header class="p-6 flex justify-between items-center bg-cover" style="background-image: url('../calendar/assets/background.jpg'); position: relative;">
        <div class="back-button">
            <a href="../home/index.php" class="m-4 bg-transparent text-white font-bold py-2 px-4 rounded-full border-2 border-white hover:bg-white hover:text-blue-500">Back</a>
        </div>
        <h1 class="text-white text-lg"></h1>
        <div onclick="window.location.href='../profile/profile.php'" class="bg-white rounded-full">
            <img class="w-12 h-12 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Picture">
        </div>
    </header>

    <div class="container mx-auto my-20">
        <div class="flex justify-center items-center mb-20 space-x-4">
            <a href="newspage.php">
                <button class="w-12 h-12 bg-blue-500 text-white rounded-full">
                    <i class="fas fa-arrow-left"></i>
                </button>
            </a>
            <h1 class="text-4xl font-bold text-center">EP Hub</h1>
        </div>

        <!-- IMAGE HERE -->
        <!-- <div class="flex justify-center items-center mb-20 space-x-4">
            <img src="https://t3.ftcdn.net/jpg/02/48/42/64/360_F_248426448_NVKLywWqArG2ADUxDq6QprtIzsF82dMF.jpg" alt="placeholder" class="rounded shadow-md">
        </div> -->

        <div class="flex justify-center items-center mb-20 space-x-4">
            <p class="text-center text-gray-700 text-base">Attendance at the upcoming event is mandatory for EP points. Failure to attend will result in no EP points awarded</p>
        </div>
        <table class="table-auto w-full mb-20">
            <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">EP</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event) : ?>
                    <tr>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($event['id']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($event['name']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($event['description']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($event['date']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($event['ep']); ?></td>
                        <td class="border px-4 py-2">
                            <?php if (!isset($_SESSION['registered'][$event['id']])) : ?>
                                <form action="" method="post">
                                    <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Register</button>
                                </form>
                            <?php else : ?>
                                <button type="button" class="bg-blue-500 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed" disabled>Registered</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>