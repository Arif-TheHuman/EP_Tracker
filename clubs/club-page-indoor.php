<?php
    include '../db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
<style>
    .header {
        padding: 30px;
        text-align: center;
        background-image: url("header.jpg");
        margin-right: -15px;
        margin-top: -10px;
        margin-bottom: auto;
        color: white;
        background-size: cover;
        background-repeat: no-repeat;
    }
    #pfp {
        width: 10%;
        height: 30%;
    }
</style>

<body>
<div class="header">
    <img id="pfp" src="https://b.fssta.com/uploads/application/soccer/headshots/885.vresize.350.350.medium.14.png" alt="Profile Image">
</div>
<div>
    <img class="sm:w-1/4 md:w-1/2 lg:w-full" src="" alt="">
</div>

<h1 class="text-center sm:text-3xl md:text-4xl lg:text-5xl ">INDOOR</h1>

<div class="justify-center items-center text-center">
<table class="w-full">
  <thead>
    <tr>
      <th class="px-6 py-3 sm:text-2xl md:text-3xl lg:text-4xl">Club</th>
      <th class="px-6 py-3 sm:text-2xl md:text-3xl lg:text-4xl">Members</th>
      <th class="px-6 py-3 sm:text-2xl md:text-3xl lg:text-4xl">Quota</th>
    </tr>
  </thead>
  <tbody class="justify-center items-center">
    <?php
        $sql = "SELECT * FROM clubs WHERE type='indoor'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td class='border px-6 py-3 sm:text-2xl md:text-3xl lg:text-4xl'><a href='club-details.php?name=".$row["name"]."'>".$row["name"]."</a></td>
                      <td class='border px-6 py-3 sm:text-2xl md:text-3xl lg:text-4xl'>".$row["current_members"]."</td>
                      <td class='border px-6 py-3 sm:text-2xl md:text-3xl lg:text-4xl'>".$row["quota"]."</td></tr>";
            }
        } else {
            echo "0 results";
        }
    ?>
  </tbody>
</table>

</div>
    
</body>
</html>
