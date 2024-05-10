<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <header class="p-6 flex justify-between items-center bg-cover" style="background-image: url('calendar/assets/background.jpg'); position: relative;">
        <div class="back-button">
            <a href="home/index.php" class="m-4 bg-transparent text-white font-bold py-2 px-4 rounded-full border-2 border-white hover:bg-white hover:text-blue-500">Back</a>
        </div>
        <h1 class="text-white text-lg"></h1>
        <div onclick="window.location.href='profile/profile.php'" class="bg-white rounded-full">
            <img class="w-12 h-12 rounded-full" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Picture">
        </div>
    </header>

    <div class="flex justify-center text-center">
        <h5 class="font-bold text-lg sm:text-xl lg:text-2xl font-montserrat">ABOUT US</h5>
    </div>
    <h5 class="font-bold text-lg sm:text-xl lg:text-2xl font-montserrat flex justify-center">Welcome to ECPS!</h5>
    <em class="font-montserrat flex justify-center text-center">Our journey began with a classroom assignment, transforming into a powerful EP points tracker for Politeknik Brunei students. Through our collaboration with CSDI, we've crafted a user-friendly app to simplify students' academic lives. With a shared passion for education, we're excited about the impact this app will make. Thank you for joining us on this empowering venture!</em>
    <br>
    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-fixed">
            <thead>
                <tr class="border-b border-gray-300">
                    <th class="w-1/3 px-4 py-2 font-bold text-lg sm:text-xl lg:text-2xl font-montserrat border-r border-gray-300">Contact Details</th>
                    <th class="w-1/3 px-4 py-2 font-bold text-lg sm:text-xl lg:text-2xl font-montserrat border-r border-gray-300">Phone Number</th>
                    <th class="w-1/3 px-4 py-2 font-bold text-lg sm:text-xl lg:text-2xl font-montserrat">Email</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 border-r border-gray-300">HakeemTheSmartie</td>
                    <td class="px-4 py-2 border-r border-gray-300">8807016</td>
                    <td class="px-4 py-2">keemi.aziz@gmail.com</td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 border-r border-gray-300">FarisTheKnight</td>
                    <td class="px-4 py-2 border-r border-gray-300">8238020</td>
                    <td class="px-4 py-2">fariszulkiffli@gmail.com</td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 border-r border-gray-300">ArifTheHuman</td>
                    <td class="px-4 py-2 border-r border-gray-300">7326604</td>
                    <td class="px-4 py-2">arifthehuman@gmail.com</td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 border-r border-gray-300">AmirThePrince</td>
                    <td class="px-4 py-2 border-r border-gray-300">8340904</td>
                    <td class="px-4 py-2">amirhuzaifah@gmail.com</td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 border-r border-gray-300">WafiqPC</td>
                    <td class="px-4 py-2 border-r border-gray-300">7223322</td>
                    <td class="px-4 py-2">wafiqmuhammad@gmail.com</td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 border-r border-gray-300">CSDI</td>
                    <td class="px-4 py-2 border-r border-gray-300">777777</td>
                    <td class="px-4 py-2">CSDI@admib.pb.edu.bn</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>