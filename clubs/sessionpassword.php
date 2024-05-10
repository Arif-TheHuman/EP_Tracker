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

    <header class="p-6 flex justify-between items-center bg-cover" style="background-image: url('../calendar/assets/background.jpg'); position: relative;">
        <div class="back-button">
            <a onclick="window.location.href='session.php?name=<?php echo urlencode($clubName); ?>'" class="m-4 bg-transparent text-white font-bold py-2 px-4 rounded-full border-2 border-white hover:bg-white hover:text-blue-500">Back</a>
        </div>
    </header>




    <div class="w-full max-w-xs mx-auto flex items-center justify-center h-screen">
        <form id="myForm" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    Please enter the session's provided Passcode to submit your attendance.
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="inputfield" type="text" placeholder="Passcode" name="passcode">
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" value="Submit">
                    Submit
                </button>
            </div>
            <?php if (!empty($message)) : ?>
                <p id="message" class="text-red-500 font-bold"><?php echo $message; ?></p>
            <?php endif; ?>
        </form>
    </div>

</body>

</html>