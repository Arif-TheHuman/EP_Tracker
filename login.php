<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-6xl mx-auto flex flex-col md:flex-row">
        <div class="md:w-3/5 md:pr-8 md:py-6">
            <div class="mb-4">
                <h1 class="text-3xl font-bold text-center">LOGIN</h1>
                <h2 class="text-sm text-center mb-4">Use your LMS login credentials to access ECPS</h2>
            </div>
        </div>
        <div class="bg-white shadow-md rounded-xl mr-0 md:mr-10 px-8 pt-6 pb-8 mb-4 md:w-2/5">
            <form action="login_process.php" method="post">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" name="username">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="password">
                </div>
                <h5 class="text-sm text-center md:text-right mb-4 text-blue-500"><a href="signup.php">Don't Have An Account?</a></h5>
                <div class="flex items-center justify-between">
                    <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" value="Sign In">
                </div>
            </form>
        </div>
    </div>
</body>
</html>