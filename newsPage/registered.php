<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <style>
        .card {
            display: flex;
            border-radius: 5px;
            width: 50%;
            height: 75%;
            justify-content: center;
        }
        
        .align-center {
            text-align: center;
        }

        .text4em{
            font-size: 4em;}

        .text3em{
            font-size: 3em;
            font-weight: bold;
            color: black;}

        .cardimage{
            display: flex;
            width: 90%;
            height: 200px;
            align-items: center;
        }

        .border4{
            border: 4px solid black;
        }

        .register-button {
            background-color: #03A4FF;
            color: white;
            padding: 20px 40px;
            font-size: 1.5em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .center {
            display: flex;
            justify-content: center;
        }

        .backie {
            width: 50px;
            height: 50px;
            margin-right:50px;
        }
    </style>

<body>
<div class="flex-container">
<a href="convoVolunteer.php">
    <img class="backie" src="assets/images/backie.png" alt="Your Avatar Description">
</a>
    <h1 class="text3em align-center">REGISTERED</h1>
    </div>
    <br>
    
    <div class="center">
    <img class="card border4" src="assets/images/regis.png" alt="Your Avatar Description">
    </div>
    <br>
    <br>

    <h1 class="align-center">Thank you for registering<br> We appreciate your participation <br>Please remember, your attendance at the upcoming event is crucial. <br> Only attendees will be eligible for EP points. <br> Your presence matters!</h1>



    
</body>
</html>