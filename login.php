<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <div class="w-full max-w-xs mx-auto mt-32 lg:flex lg:items-start lg:flex-row lg:gap-4">
        <div class="lg:w-[120%]">
            <div class="lg:w-full">
                <h1 class="text-3xl font-bold">LOGIN</h1>
                <h2 class="text-sm mb-4">Use your LMS login credentials to access ECPS</h2>
            </div>
        </div>
        <div class="lg:w-">
            <form action="login_process.php" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 sm:bg-white sm:shadow-md sm:rounded sm:px-4 sm:pt-3 sm:pb-4 sm:mb-2 lg:ml-8 lg:mr-8 lg:px-10 lg:pt-8 lg:pb-10 lg:mb-6 col-span-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-md font-bold mb-2" for="username">
                        Username
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-3 px-8 lg:py-4 lg:px-20 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" name="username">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-md font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-3 px-8 lg:py-4 lg:px-20 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password">
                </div>
                <div class="flex items-center justify-between">
                    <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-8 lg:py-4 lg:px-8 rounded focus:outline-none focus:shadow-outline" type="submit" value="Sign In">
                </div>
            </form>
        </div>
    </div>
</body>
</body>
</html>