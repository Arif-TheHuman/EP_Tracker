<?php 

$ep = 50;
$percentage = round($ep / 64 * 100);
$req = 64 - $ep;
if ($ep > 64) {
    $req = 0;
}
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
<nav class="p-4" style="background-image: url('https://static.vecteezy.com/system/resources/previews/007/685/830/non_2x/colorful-geometric-background-trendy-gradient-shapes-composition-cool-background-design-for-posters-free-vector.jpg'); background-size: cover;">
    <div class="container mx-auto flex items-center justify-between">
        <a class="text-lg font-semibold text-white" href="#">EP Tracker</a>
        <div class="flex items-center space-x-4">
            <a class="text-white hover:text-gray-300" href="#">Home</a>
            <a class="text-white hover:text-gray-300" href="#">About</a>
            <a class="text-white hover:text-gray-300" href="#">Contact</a>
            <img class="h-8 w-8 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Image">
        </div>
    </div>
</nav>
<br>
<div style="background-image: url('https://i0.wp.com/boingboing.net/wp-content/uploads/2018/05/cool-background1.png?fit=930%2C468&ssl=1'); background-size: cover;" class="relative flex justify-center items-center h-64 w-3/4 bg-gray-400 mx-auto">
    <button class="absolute top-0 right-0 m-4 bg-transparent text-black font-bold py-2 px-4 rounded-full border-2 border-black">
        +
    </button>
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
        <h1 class="text-lg"><?php echo strtoupper($ep)?> OUT OF 64 EP</h1>
        <p class="text-lg"><?php echo $req; ?> EP REQUIRED</p>
    </div>
</div>
<br>
<div>
    <h1>Outdoor Clubs</h1>
    <div class="overflow-x-auto whitespace-nowrap py-4">
    <?php 
    $clubs = [
        ["name" => "Club 1", "image" => "https://path-to-image-1.jpg"],
        ["name" => "Club 2", "image" => "https://path-to-image-2.jpg"],
        // Add more clubs as needed
    ];
    foreach ($clubs as $club) : ?>
        <div class="inline-block mx-2">
            <img class="w-64 h-64 object-cover" src="<?php echo $club['image']; ?>" alt="<?php echo $club['name']; ?>">
            <p class="text-center"><?php echo $club['name']; ?></p>
        </div>
    <?php endforeach; ?>
</div>
</div>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto text-center">
            <p>Copyright &copy; 2024 EP Tracker</p>
        </div>
    </footer>
</body>
</html>