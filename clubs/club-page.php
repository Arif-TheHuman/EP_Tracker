<?php
    include '../db_connection.php';
    $type = $_GET['type'] ?? 'indoor'; // Default to 'indoor'
    $types = ['indoor', 'outdoor', 'society'];
    $currentIndex = array_search($type, $types);
    $previousType = $types[($currentIndex - 1 + count($types)) % count($types)];
    $nextType = $types[($currentIndex + 1) % count($types)];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="p-10 text-center bg-center bg-cover bg-blue-500 text-white" style="background-image: url('header.jpg');">
        <img id="pfp" class="w-24 h-24 mx-auto rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Image">
    </div>
    <a href="../home/index.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back</a>
    <div class="container mx-auto my-10">
        <div class="text-center mb-10">
            <a href="?type=<?php echo $previousType; ?>" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-l">&lt;</a>
            <h1 class="inline-block sm:text-3xl md:text-4xl lg:text-5xl mx-4 bg-white shadow p-2 rounded"><?php echo strtoupper($type); ?></h1>
            <a href="?type=<?php echo $nextType; ?>" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-r">&gt;</a>
        </div>
        <div class="justify-center items-center text-center">
            <table class="w-full bg-white shadow rounded">
                <thead>
                    <tr>
                        <th class="px-6 py-3 sm:text-2xl md:text-3xl lg:text-4xl bg-blue-500 text-white">Club</th>
                        <th class="px-6 py-3 sm:text-2xl md:text-3xl lg:text-4xl bg-blue-500 text-white">Members</th>
                        <th class="px-6 py-3 sm:text-2xl md:text-3xl lg:text-4xl bg-blue-500 text-white">Quota</th>
                    </tr>
                </thead>
                <tbody class="justify-center items-center">
                    <?php
                        $sql = "SELECT * FROM clubs WHERE type='$type'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr><td class='border px-6 py-3 sm:text-2xl md:text-3xl lg:text-4xl flex items-center'><img class='w-12 h-12 rounded-full mr-4' src='".$row["profilePic"]."' alt='Club Profile Pic'><a href='club-details.php?name=".$row["name"]."'>".$row["name"]."</a></td>
                                    <td class='border px-6 py-3 sm:text-2xl md:text-3xl lg:text-4xl'>".$row["current_members"]."</td>
                                    <td class='border px-6 py-3 sm:text-2xl md:text-3xl lg:text-4xl'>".$row["quota"]."</td></tr>";
                            }
                        } else {
                            echo "0 results";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>