<!DOCTYPE html>
<html>
<head>
    <style>
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
            background-color: #000;
        }

        .top-rectangle button {
            margin-left: 10px; /* Adjust as needed */
            color: #fff; /* Adjust as needed */
            background-color: #f00; /* Adjust as needed */
        }

        .bottom-rectangle {
            position: absolute;
            top: 40px; /* This should be the same as the height of the top rectangle */
            left: 0;
            background-color: #f00; /* Change this to the color you want */
        }

        .center-rectangle {
            position: absolute;
            top: 20%;
            left: 50%;
            width: 90%; /* Adjust as needed */
            height: 5%; /* Adjust as needed */
            background-color: #00f; /* Change this to the color you want */
            transform: translate(-50%, -50%);
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
        <button>Click me</button>
    </div>
    <div class="bottom-rectangle"></div>

    <!-- Rest of your content goes here -->
</body>
</html>
