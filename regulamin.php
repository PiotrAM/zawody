﻿<?php

session_start();

?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>

 <link rel="stylesheet" href="styl.css">
 <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,900&display=swap" rel="stylesheet">

   
    <meta charset="utf-8" />
    <title>Zawody</title>
    <style>

    #pdf {
    width: 80%;
    height: 975px;
    margin-top: 150px;
}

     </style>
</head>
<body>

<header>
<?php
if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin') {
    echo '<a href="admin.php">
            <h2 class="logo">Logo</h2>
          </a>';
} elseif (isset($_SESSION['user'])) {
    echo '<a href="main.php">
            <h2 class="logo">Logo</h2>
          </a>';
} else {    
    echo '<h2 class="logo">Logo</h2>';
}
?>

<input type="checkbox" id="checkbox_toggle">
<label for="checkbox_toggle" class="hamburger">&#9776</label>
<nav class="navbar">  
      <a href="regulamin.php"> Regulamin </a>

        <?php       
        if(isset($_SESSION['zalogowany'])) {
            echo ' <a href="zapisy.php"> Zapisy </a>';
        } 
        ?>
       
    <div class="dropdown">
    <a href="#"> Wyniki </a>
  <ul>
    <li><a href="wyniki.php?rok=2021">2021</a></li>
    <li><a href="wyniki.php?rok=2022">2022</a></li>
    <li><a href="wyniki.php?rok=2023">2023</a></li>
</ul>
     </div>
       <a href="trasa.php"> Trasa </a>
        <?php       
        if(isset($_SESSION['zalogowany'])) {
            echo '<a href="logout.php">Wyloguj</a>';
        } else {
            echo '<a href="logowanie.php">Logowanie</a>';
        }
        ?>
    <a href="rejestracja.php">Rejestracja</a>
 
    </nav>
</header>

<iframe id="pdf" src="RegulaminAM.pdf" frameorder="1"><iframe>
 


   
</body>
</html>