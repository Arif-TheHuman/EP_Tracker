<?php 
session_start();
$clubName = $_GET['name'];
$message = '';
$password = '1234';
$buttonDisabled = false; // Initialize to false
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["passcode"])) {
        $message = "Error: Passcode not entered. Please provide a valid passcode to proceed.";
    } else {
        $passcode = $_POST["passcode"];
        if ($passcode == $password) {
            $_SESSION['attendance_status'] = 'Present'; // Store the successful login status in a session variable
            header('Location: session.php?name=' . urlencode($clubName)); // Redirect to session.php
            exit(); // Ensure no further execution
        } else {
            $message = "Error: Incorrect passcode. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Session Code</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-montserrat">
    <h1 class="text-center fixed w-full top-0">Session</h1>
    <img src="../assets/person.png" alt="Person" class="mx-auto block w-1/10 pt-16">
    <div class="bg-cover w-full h-48 mt-24" style="background-image: url('../assets/figmating2.png');">
        <div class="bg-blue-500 w-full h-12 flex items-center justify-center">
            <p class="text-lg text-black m-0 font-bold">Please enter the session's provided Passcode to submit your attendance.</p>
        </div>
        <form id="myForm" method="post" class="mt-5">
    <input type="text" id="inputfield" class="bg-white w-48 h-8 border-none rounded px-2" name="passcode">
    <input type="submit" class="bg-blue-500 text-white border-none px-5 py-2 text-center cursor-pointer inline-block text-lg mx-1 my-2" value="Submit">
    <?php if (!empty($message)): ?>
        <p id="message" class="text-red-500 font-bold"><?php echo $message; ?></p>
    <?php endif; ?>
</form>
    </div>
    <button class="fixed top-2 left-2 w-8 h-8" style="background-image: url('../assets/arrow.png'); background-size: cover;" onclick="window.location.href='session.php?name=<?php echo urlencode($clubName); ?>'"></button>
</body>
</html>