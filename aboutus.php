<!DOCTYPE html>
<html>
<head>
    <style>
em {
    font-family: 'Montserrat', sans-serif;
}
.centered-image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Adjust as needed */
            flex-wrap: wrap; /* Allow the images to wrap to the next line if necessary */
        }

        .centered-image {
            max-width: 100%; /* This will make the image responsive */
            border: 1px solid #000; /* Add a 1px border */
            margin: 10px; /* Add some space between the images */
        }
        .rectangle {
            width: 100%;
            height: 36px; /* Adjust the height to match the circle's size */
            background-color: #ccc;
            background-image: url(path/to/your/image.jpg);
            background-size: cover;
            background-position: center;
            overflow: hidden; 
        }
        .rounded-image {
            float: right;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #fff;
            background-image: url(path/to/your/rounded-image.jpg);
            background-size: cover;
            background-position: center;
            margin: 10px; /* Add margin to ensure the circle doesn't touch the rectangle's edges */
        }
        h5 {
            font-weight: bold; 
            font-family: 'Montserrat', sans-serif;
        }

        /* For screens smaller than 600px */
        @media only screen and (max-width: 600px) {
            h5 {
                font-size: 16px;
            }
        }
        @media only screen and (min-width: 601px) and (max-width: 1200px) {
            h5 {
                font-size: 20px;
            }
        }

        /* For screens larger than 1200px */
        @media only screen and (min-width: 1201px) {
            h5 {
                font-size: 24px;
            }
        }
        
    </style>
</head>
<body>
    <div class="rectangle">
        <div class="rounded-image"></div>
    </div>
    <div style="position: absolute; top: 36px; left: 0;">
        <h5>ABOUT US</h5>
    </div>
    <div class="centered-image-container">
        <img class="centered-image" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Your Image">
    </div>
    <h5>Welcome to ECPS!</h5>
    <em>Our journey began with a classroom assignment, transforming into a powerful EP points tracker for Politeknik Brunei students. Through our collaboration with CSDI, we've crafted a user-friendly app to simplify students' academic lives. With a shared passion for education, we're excited about the impact this app will make. Thank you for joining us on this empowering venture!</em>
    <h5>CONTACT DETAILS</h5>  <br></br>
    <em>Hakeem Azeez</em>  <br></br>
    <em>Phone Number: 8807016</em>  <br></br>
    <em>Email: keemi.aziz@gmail.com</em>  <br></br>
    <br></br>
    <em>CSDI</em>  <br></br>
    <em>Phone Number:777777</em>  <br></br>
    <em>Email: CSDI@admib.pb.edu.bn</em>
</body>
</html>