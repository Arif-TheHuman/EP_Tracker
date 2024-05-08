<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="flex flex-col">
        <!-- Red colored div -->
        <div class="w-full bg-red-500 h-50 flex items-center justify-center">
            <div class="bg-white rounded-full p-2 inline-block">
                <img class="w-24 h-24 rounded-full mx-auto" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Image">
            </div>
        </div>

        <!-- White colored div -->
        <div class="w-full bg-white-500">
            <div class="flex flex-col items-center justify-center min-h-screen">
                <div class="w-full max-w-md">
                    <!-- Input Name -->
                    <h1>Name</h1>
                    <input class="mb-4 w-full px-3 py-2 placeholder-gray-500 text-gray-900 rounded-full border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text" placeholder="Input 1" readonly>

                    <!-- Input Email Address -->
                    <h1>Email Address</h1>
                    <input class="mb-4 w-full px-3 py-2 placeholder-gray-500 text-gray-900 rounded-full border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text" placeholder="Input 2" readonly>

                    <!-- Input Phone Number -->
                    <h1>Phone Number</h1>
                    <input class="mb-4 w-full px-3 py-2 placeholder-gray-500 text-gray-900 rounded-full border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text" placeholder="Input 3" readonly>

                    <!-- Input Role Type -->
                    <h1>Role Type</h1>
                    <input class="mb-4 w-full px-3 py-2 placeholder-gray-500 text-gray-900 rounded-full border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text" placeholder="Input 4" readonly>

                    <!-- Buttons -->
                    <h1>Group & Club</h1>
                    <input class="mb-4 w-full px-3 py-2 placeholder-gray-500 text-gray-900 rounded-full border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" type="text" placeholder="Input 5" readonly>

                    <div class="flex justify-center mt-4">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-2">
                            Enrichment Point
                        </button>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-2">
                            Edit Profile
                        </button>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-2">
                            Log out
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blue colored div -->
        <div class="w-full bg-blue-500 h-12"></div>
    </div>
</body>

</html>