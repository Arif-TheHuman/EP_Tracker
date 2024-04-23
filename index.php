<?php 
$percentage = 30;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EP Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <!-- Navigation Bar -->
<nav class="bg-white p-4">
    <div class="container mx-auto flex items-center justify-between">
        <a class="text-lg font-semibold text-gray-900" href="#">EP Tracker</a>
        <div class="flex items-center space-x-4">
            <a class="text-gray-600 hover:text-gray-900" href="#">Home</a>
            <a class="text-gray-600 hover:text-gray-900" href="#">About</a>
            <a class="text-gray-600 hover:text-gray-900" href="#">Contact</a>
            <img class="h-8 w-8 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Image">
        </div>
    </div>
</nav>
    <!-- Hero Section -->
    <header class="bg-blue-500 text-white text-center py-16 mb-8">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold">Welcome to EP Tracker</h1>
            <p class="text-lg">Track your EP with ease</p>
        </div>
    </header>
    <div class="flex justify-center items-center h-64 w-full bg-gray-400 mx-auto">
    <div class="w-1/2">
        <svg class="w-64 h-64 mx-auto" viewBox="0 0 36 36">
            <path class="circle-bg"
                d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"
                fill="none"
                stroke="#eee"
                stroke-width="2.5"
                />
            <path class="circle"
                stroke="#4c51bf"
                stroke-dasharray="<?php echo $percentage; ?>, 100"
                d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831"
                fill="none"
                stroke-width="2.5"
                stroke-linecap="round"
                />
                <text x="18" y="18" class="percentage" fill="#4c51bf" text-anchor="middle" dy=".3em" font-size="8"><?php echo $percentage; ?>%</text>
        </svg>
    </div>
    <div class="w-1/2 text-center">
        <h2 class="text-2xl font-bold mb-4">Your Progress</h2>
        <p class="text-lg">You have completed <?php echo $percentage; ?>% of your goal. Keep going!</p>
    </div>
</div>
<br>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto text-center">
            <p>Copyright &copy; 2024 EP Tracker</p>
        </div>
    </footer>
</body>
</html>