<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$dbname = "profileDB";
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database checked/created successfully";
} else {
    echo "Error checking/creating database: " . $conn->error;
}

// Select the database
$conn->select_db($dbname);

// Create table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS profiles (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    phone VARCHAR(15),
    role_type VARCHAR(30)
    )";

if ($conn->query($sql) === TRUE) {
    echo "Table checked/created successfully";
} else {
    echo "Error checking/creating table: " . $conn->error;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role_type = $_POST['role_type'];

    // Insert data into database
    $sql = "INSERT INTO profiles (name, email, phone, role_type) VALUES ('$name', '$email', '$phone', '$role_type')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            gap: 20px;
            height: 400px;
            width: 350px;
        }

        input {
            width: 280px;
            border: 1px solid #000;
        }

        buton {
            width: 400px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <div class="center">
        <div id="div" class="p-6 max-w-sm mx-auto bg-white shadow-md flex items-center space-x-4 flex-col">
            <div>
                <h1>Edit Profile</h1>
            </div>

            <div>
                <div class="flex justify-between items-center">
                    <h1>&nbsp;Name</h1>
                </div>
                <input type="text" name="name" value="<?php echo $row['name']; ?>">
            </div>

            <div>
                <div class="flex justify-between items-center">
                    <h1>&nbsp;Email Address</h1>
                </div>
                <input type="text" name="email" value="<?php echo $row['email']; ?>">
            </div>

            <div>
                <div class="flex justify-between items-center">
                    <h1>&nbsp;Phone Number</h1>
                </div>
                <input type="text" name="phone" value="<?php echo $row['phone']; ?>">
            </div>

            <div>
                <h1>&nbsp;Role Type</h1>
                <input type="text" name="role_type" value="<?php echo $row['role_type']; ?>">
            </div>

            <div class="flex justify-center">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">Update</button>
                <button onclick="window.location.href='profile.php'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2 ml-4">Go Back</button>
            </div>

        </div>
    </div>
</body>

</html>