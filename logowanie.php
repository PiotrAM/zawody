<?php

session_start();

if(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true))
{

header('Location:index.php');
exit();

}
?>


<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>


<link rel="stylesheet" href="styl.css">

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

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




    <div class="box">
       
        <div class="container">
            <div class="top-header">
            <span><a href="rejestracja.php"> Rejestracja-załóż konto></a></span>
            <h1> LOGOWANIE </h1>
    <br/>
    </div>
    <form action="zaloguj.php" method="post"> 
    <div class="input-field">
        Login <br /> <input type="text" class="input" placeholder="Login" name="login" />
        <ion-icon style="color:white; position: relative;
    top: -31px; left: 17px;" name="person-outline"></ion-icon>
        </div>
         <div class="input-field">
        Haslo <br /> <input type="password" class="input" placeholder="Password"name="haslo" />
         <ion-icon style="color:white; position: relative;
    top: -31px; left: 17px;"name="lock-closed-outline"></ion-icon>
         </div>
         <div class="input-field">
        <input type="submit"class="submit" value="Zaloguj się" />
     </div>
     
     <div class="bottom">
     <div class="left">
     <input type="checkbox"id="check"/>
     <label for="check"> Remember Me</label>

     </div>

     <div class="right">
     <label><a href="#"> Forgot password?</label>
     </div>

     </div>

    </form>
         </div>
    </div>
</body>
</html>