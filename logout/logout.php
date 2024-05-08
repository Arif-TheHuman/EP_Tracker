<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-image: url('https://static.vecteezy.com/system/resources/previews/013/109/674/large_2x/pastel-blue-aesthetic-background-can-use-for-print-template-fabric-presentation-textile-banner-poster-wallpaper-digital-paper-free-photo.jpg');
            background-size: cover;
            background-position: center;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #div {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* Add this line */
            gap: 20px;
            height: 400px;
            width: 350px;
        }

        img {
            width: 300px;
            height: 300px;
        }

        button {
            width: 280px;
        }
    </style>
    <title>Logout</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <div class="center">
        <div id="div" class="p-6 max-w-sm mx-auto bg-white shadow-md flex items-center space-x-4 flex-col">
            <img src="sadderz.png" alt="">
            <h2>Do you really want to log out?</h2>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2 w-full">Yes</button>
            <a href="../profile/profile.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-2 block text-center w-full">No</a>
        </div>
    </div>


</body>

</html>