<head>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .button {
            background-image: url('./assets/arrow.png');
            background-size: cover;
            width: 30px;
            height: 30px;
            position: fixed;
            top: 10px;
            left: 10px;
        }
        h1 {
            font-family: 'Montserrat', sans-serif;
            text-align: center;
            position: fixed;
            width: 100%;
            top: 0;
        }
        .person {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 10%;
            padding-top: 70px;
        }
        .bigrectangle {
            background-image: url('./assets/figmating2.png');
            background-size: cover;
            width: 100%;
            height: 200px;
            margin-top: 100px;
        }
        .toprectangle {
            background-color: #03A4FF;
            width: 100%;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .toprectangle p {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.25em; /* h5 size */
            color: black;
            margin: 0;
            font-weight: bold;
        }
        .inputfield {
            background-color: white;
            width: 200px;
            height: 30px;
            border: none;
            border-radius: 5px;
            padding: 5px;
            margin-top: 20px;
        }
        .submitbutton {
    background-color: #03A4FF;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
    </style>
</head>
<body>
    <h1>Session</h1>
    <img src="./assets/person.png" alt="Person" class="person">
    <div class="bigrectangle">
        <div class="toprectangle">
            <p>Please enter the session's provided Passcode to submit your attendance.</p>
        </div>
        <form id="myForm">
            <input type="text" id="inputfield" class="inputfield">
            <input type="submit" class="submitbutton" value="Submit">
            <p id="message" style="display: none; color: red; font-weight: bold;">Error: Passcode not entered. Please provide a valid passcode to proceed.</p>
        </form>
    </div>
    <button class="button"></button> 
</body>
<script>
    document.getElementById('myForm').addEventListener('submit', function(event) {
        var input = document.getElementById('inputfield');
        var message = document.getElementById('message');
        if (input.value === '') {
            event.preventDefault();
            message.style.display = 'block';
        } else {
            message.style.display = 'none';
        }
    });
</script>
</html>