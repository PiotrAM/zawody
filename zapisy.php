<?php
session_start();

require_once "connect.php";
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

$rok = "2024";

$query = "SELECT wyniki.*, uzytkownicy.name, uzytkownicy.surname 
          FROM `$rok` AS wyniki
          JOIN uzytkownicy ON wyniki.Id_user = uzytkownicy.id";

$result = mysqli_query($polaczenie, $query);

$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

$_SESSION['wyniki_' . $rok] = $rows;

mysqli_close($polaczenie);
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
       
        .highlight-panel {
            background-color: silver;
            border: 2px solid #ccc;
            padding: 10px;
            margin: 20px;
            border-radius: 10px;
        }

        .highlight-panel h1 {
            margin-bottom: 10px;
        }

        .highlight-panel p {
            margin: 0;
            padding: 5px;
            border-bottom: 1px solid #ccc;
        }

        form {
            text-align: center;
            margin-top: 100px; 
        }

        input[type="submit"] {
            padding: 30px; 
            font-size: 24px; 
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
<div class="relative">
<div >
    <form action="zapisy_process.php" method="post">
        <input type="submit" name="submit" value="Zapisz się na zawody">
    </form>
</div>

<div class="highlight-panel">
    <?php
    $sesja_key = 'wyniki_' . $rok;
    if (isset($_SESSION[$sesja_key])) {
        $wyniki_rok = $_SESSION[$sesja_key];
        echo '<h1>LISTA ZAWODNIKÓW </br> ROK: '.$rok.'</h1>';
        foreach ($wyniki_rok as $row) {
            echo '<p>Imię: ' . $row['name'] . ' - Nazwisko: ' . $row['surname'] . '</p>';
        }
    }
    ?>
</div>

</div>


   
</body>
</html>