<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    </head>
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: url('assets/images/head.png') no-repeat center center / cover;
            width: 100%;
            height: 200px;
            text-align: center;
            align-items: center;
        }

        .card {
            display: flex;
            border-radius: 5px;
            width: 75%;
            height: 75%;
            justify-content: center;
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

        .center {
            display: flex;
            justify-content: center;
        }

        .flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .backie {
            width: 50px;
            height: 50px;
            margin-right:75px;
        }
    </style>

<body>
    <div class="header">
        <img class="avatar" src="assets/images/ronaldo.png" alt="Your Avatar Description">
    </div>

    <div class="flex-container">
<a href="newspage.php">
    <img class="backie" src="assets/images/backie.png" alt="Your Avatar Description">
</a>
    <h1 class="text3em align-center">HIV AWARENESS PROGRAMME</h1>
    </div>
    <br>
    
    <div class="center">
    <img class="card border4" src="assets/images/happy.png" alt="Your Avatar Description">
    </div>
    <br>
    <br>

    <h1>HIV Awareness Programme for Peers <br>and Youth is now open for registration. <br> Interested students can register now. <br>#EndorsedforEP #HAPPY #SAD</h`>
<br>
<br>

<h1 class="center"></h1>
    <div class="center">
        <a href="registered2.php" class="register-button">REGISTER NOW</a>
    </div>
</body>
</html>