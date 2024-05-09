<?php
    $clubId = $_GET['clubId'];
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body class="font-montserrat">
    <div class="absolute top-0 left-0 w-full h-10 bg-cover" style="background-image: url(./assets/figmatingy1.jpg);">
        <button id="back" class="ml-2 text-transparent bg-transparent">
            <img src="./assets/arrow.png" alt="Image">
        </button>
       <div id="session" class="font-bold justify-center"><h5 id="session">SESSION</h5></div>
    </div>
    <div class="absolute top-10 left-0 w-full h-10 bg-cover" style="background-image: url(./assets/figmating2.png);"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-9/10 h-1 bg-blue-500 flex items-center justify-between">
        <div class="date">Date</div>  
        <div class="submit">Submit</div>
    </div>
    <?php
// Dummy data
$dummyData = [
    ['date' => '2024-04-24', 'submitted' => true],
    ['date' => '2024-04-25', 'submitted' => false],
    ['date' => '2024-04-26', 'submitted' => true],
    // Add more dummy data as needed
];
foreach ($dummyData as $data) {
    $date = $data['date'];
    $submitted = $data['submitted'];
    // Check if date data exists
    if (!empty($date)) {
        // Display custom rectangle with date and submitted status
        echo '<div class="bg-gray-200 p-2 rounded-md">';
        echo '<div class="flex items-center justify-between">';
        echo '<div class="text-left font-bold">' . $date . '</div>';
        echo '<div class="text-right font-bold">Submitted: ' . ($submitted ? 'Yes' : 'No') . '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>
    <!-- Rest of your content goes here -->
</body>
</html>