<?php

session_start();

if(!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}

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
    .napis {
    color: white;
    position: fixed;
    top: 150px;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    width: 100%;
    box-sizing: border-box;
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
    <li> <a href="#"> 2021</a></li>
    <li> <a href="#"> 2022</a></li>
    <li> <a href="#"> 2023</a></li>
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


<div class="napis">
<?php
echo '<div style="background-color: #66b2ff; padding: 10px; border-radius: 8px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2); position: relative; top: 50px; left: 50%; transform: translateX(-50%);">';
echo '<p style="text-transform: uppercase; color: #fff; font-size: 24px; text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.5);">';
echo 'Witaj ' . $_SESSION['name'] . '!!![<a href="logout.php" style="color: #fff;">Wyloguj się!</a>]</p>';
echo '<p style="color: #fff;">' . $_SESSION['surname'] . '!!!</p>';
echo '<p style="color: #fff;">Udział w zawodach: ' . $_SESSION['number_competition'] . ' razy!!!</p>';
echo '</div>';
?>
</div>

 </span>
</body>
</html>