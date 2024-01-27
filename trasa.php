<?php

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


<iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d17293.592519867703!2d19.678680784992487!3d52.54383427969476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e2!4m5!1s0x471c7a64ca7fe827%3A0x7aeab35bab8c2b6e!2sAkademia%20Mazowiecka%20w%20P%C5%82ocku!3m2!1d52.5582552!2d19.6811674!4m5!1s0x471c70a27af9bacb%3A0x16e3b53ff8b5718f!2sAkademia%20Mazowiecka%20w%20P%C5%82ocku!3m2!1d52.539360699999996!2d19.697423699999998!5e0!3m2!1spl!2spl!4v1704793262422!5m2!1spl!2spl" 
width="750" height="600" style="border:5;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> 




   
</body>
</html>