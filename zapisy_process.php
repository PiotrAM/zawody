
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
 <a href="main.php">
<h2 class="logo">Logo</h2>
</a>
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

<?php
session_start();

if (!(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] == true)) {
    header('Location: index.php');
    exit();
}

require_once "connect.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
if ($polaczenie->connect_error) {
    die("Błąd połączenia: " . $polaczenie->connect_error);
}

if (isset($_POST['submit'])) {
    $id_user = $_SESSION['id'];
    $user = $_SESSION['user'];

    // Sprawdź, czy użytkownik już jest zapisany
    $check_sql = "SELECT * FROM `2024` WHERE `Id_user` = $id_user";
    $result = $polaczenie->query($check_sql);

    if ($result && $result->num_rows > 0) {
        echo "Jesteś już zapisany na zawody!";
        echo '<a href="main.php">Powrót na stronę główną </a>';
    } else {
        // Jeśli użytkownik nie jest jeszcze zapisany, dokonaj zapisu
        $insert_sql = "INSERT INTO `2024` (`Id_user`) VALUES ($id_user)";

        if ($polaczenie->query($insert_sql) === TRUE) {
            echo "Zapisano na zawody!";
            echo '<a href="main.php">Powrót na stronę główną </a>';
        } else {
            echo "Błąd: " . $polaczenie->error;
        }
    }
}

$polaczenie->close();
?>



   
</body>
</html>