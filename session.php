<!DOCTYPE html>
<html>
<head>
    <style>
        .center-rectangle {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Added to space out the date and time */
        }

        .center-rectangle div {
            flex: 1;
        }

        .date-info {
            text-align: left;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif;
        }

        .submission-info {
            text-align: right;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif;
        }

        .custom-rectangle {
            background-color: #ccc;
            padding: 10px;
            border-radius: 5px;
        }



        .center-rectangle {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Added to space out the date and time */
        }

        .center-rectangle div {
            flex: 1;
        }

        .date {
            text-align: left;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif;
        }

        .submit {
            text-align: right;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif;
        }

        .top-rectangle, .bottom-rectangle, .center-rectangle {
            display: flex;
            align-items: center;
        }

        .top-rectangle, .bottom-rectangle {
            width: 100%;
            height: 40px;
        }

        .top-rectangle {
            position: absolute;
            top: 0;
            left: 0;
            background-image: url(./assets/figmatingy1.jpg); /* Uncomment and replace 'your-image-url' with your actual image URL if you want to use a background image */
        }

        .top-rectangle button {
            margin-left: 10px; /* Adjust as needed */
            color: transparent; /* Adjust as needed */
            background: transparent; /* Adjust as needed */
        }

        .bottom-rectangle {
            position: absolute;
            top: 40px; /* This should be the same as the height of the top rectangle */
            left: 0;
            background-image: url(./assets/figmating2.png); /* Change this to the color you want */
        }

        .center-rectangle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%; /* Adjust as needed */
            height: 5%; /* Adjust as needed */
            background-color: #03A4FF; /* Change this to the color you want */
        }

        /* Media query for screens smaller than 600px */
        @media (max-width: 600px) {
            .top-rectangle, .bottom-rectangle {
                height: 30px;
            }

            .bottom-rectangle {
                top: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="top-rectangle">
        <button id="back">
            <img src="./assets/arrow.png" alt="Image">
        </button>
       <div id="session"> <h5 id="session" style="font-weight: bold; font-family: 'Montserrat', sans-serif; justify-content: center;">SESSION</h5> </div>
    </div>
    <div class="bottom-rectangle"></div>

    <div class="center-rectangle">
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
        echo '<div class="custom-rectangle">';
        echo '<div class="center-rectangle">';
        echo '<div class="date-info">' . $date . '</div>';
        echo '<div class="submission-info">Submitted: ' . ($submitted ? 'Yes' : 'No') . '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>
    <!-- Rest of your content goes here -->
</body>
</html>
