<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: url('assets/images/head.png') no-repeat center center / cover;
            width: 100%;
            height: 200px;
        }

        .card {
            background: url('assets/images/bgcard.png') no-repeat center center / cover;
            border-radius: 5px;
            padding: 20px;
            color: white;
            width: 80%;
            height: 20%;
            text-align: center;
            align-items: center;
            margin-left : 10%;

        }

        .avatar {
            border-radius: 50%;
            height: 100px;
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
            width: 65%;
            height: 14%;
            border-radius: 5%;
        }

        .flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .frontie {
            width: 50px;
            height: 50px;
            margin-left:75px;
        }

    </style>

<body>
    <div class="header">
        <img class="avatar" src="assets/images/ronaldo.png" alt="Your Avatar Description">
    </div>

    <div class="flex-container">
    <h1 class="text3em align-center">News & Announcement</h1>
<a href="newspage.php">
    <img class="frontie" src="assets/images/frontie.png" alt="Your Avatar Description">
</a>
    </div>
    <br>

    <a href="convoVolunteer.php">
    <div class="card">
    <img class="cardimage" src="assets/images/imgcard1.png" alt="Image Description">
        <p class="text3em">CONVO VOLUNTEER IN NEED</p>
    </div>
    </a>

    <br>
    <br>

    <a href="HivAware.php">
    <div class="card">
    <img class="cardimage" src="assets/images/imgcard2.png" alt="Image Description">
        <p class="text3em">HIV AWARENESS PROGRAMME</p>
    </div>
    </a>

    <br>
    <br>

    <a href="SignWorkshop.php">
    <div class="card">
    <img class="cardimage" src="assets/images/imgcard3.png" alt="Image Description">
        <p class="text3em">SIGN LANGUAGE WORKSHOP</p>
    </div>  
    </a>
    
    <br>
    <br>


    
</body>
</html>