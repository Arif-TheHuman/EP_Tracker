<?php
session_start(); // Start the session
include '../db_connection.php';
if (isset($_SESSION['user']['username'])) {
    $username = $_SESSION['user']['username']; // Set the $username variable
} else {
    echo "Username is not set in the session";
    exit(); // Stop the script if the username is not set in the session
}
// Fetch the user's data from the database
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone'];
    $userSchoolRole = $_POST['role_type'];
    // Update data in the database
    $sql = "UPDATE users SET username = ?, email = ?, phone_number = ?, userRoleSchool = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $phone_number, $userSchoolRole, $username);
    if ($stmt->execute()) {
        echo "Record updated successfully";
        // Update the session data
        $_SESSION['user']['username'] = $name;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phone_number'] = $phone_number;
        $_SESSION['user']['userRoleSchool'] = $userSchoolRole;
    } else {
        echo "Error updating record: " . $conn->error;
    }
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
<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <div class="flex items-center justify-center h-screen">
        <div class="p-6 max-w-sm mx-auto bg-white shadow-md flex items-center space-x-4 flex-col">
            <div class="w-full text-right mb-4">
                <button onclick="window.history.back()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Go Back</button>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Edit Profile</h1>
            </div>
            <form method="POST" action="">
                <div class="flex flex-col space-y-4">
                    <div>
                        <h1 class="font-bold">Name</h1>
                        <input type="text" name="name" value="<?php echo $user['username']; ?>" class="w-full border border-black">
                    </div>
                    <div>
                        <h1 class="font-bold">Email Address</h1>
                        <input type="text" name="email" value="<?php echo $user['email']; ?>" class="w-full border border-black">
                    </div>
                    <div>
                        <h1 class="font-bold">Phone Number</h1>
                        <input type="text" name="phone" value="<?php echo $user['phone_number']; ?>" class="w-full border border-black">
                    </div>
                    <div>
                        <h1 class="font-bold">Role Type</h1>
                        <input type="text" name="role_type" value="<?php echo $user['userRoleSchool']; ?>" class="w-full border border-black">
                    </div>
                    <div class="flex justify-center space-x-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>