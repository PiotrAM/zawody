<?php
session_start();

if (!isset($_SESSION['zalogowany'])) {
    header('Location: index.php');
    exit();
}

require_once "connect.php";
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
if ($polaczenie->connect_error) {
    die("Błąd połączenia: " . $polaczenie->connect_error);
}

if (isset($_POST['usun_z_zawodow'])) {
    $nazwisko = $_POST['nazwisko'];
    $imie = $_POST['imie'];

    // Znajdź id użytkownika na podstawie nazwiska i imienia
    $select_user_id_sql = "SELECT id FROM uzytkownicy WHERE surname = '$nazwisko' AND name = '$imie'";
    $result_user_id = $polaczenie->query($select_user_id_sql);

    if ($result_user_id->num_rows > 0) {
        $row = $result_user_id->fetch_assoc();
        $user_id = $row['id'];

        // Usuń rekord z tabeli 2024 na podstawie id użytkownika
     $delete_sql = "DELETE `2024` FROM `2024`
               INNER JOIN `uzytkownicy` ON `2024`.`Id_user` = `uzytkownicy`.`id`
               WHERE `uzytkownicy`.`id` = $user_id";



        if ($polaczenie->query($delete_sql) === TRUE) {
            echo "Usunięto zawodnika z zawodów!";
        } else {
            echo "Błąd: " . $polaczenie->error;
        }
    } else {
        echo "Nie znaleziono użytkownika o podanym nazwisku i imieniu.";
    }
}

if (isset($_POST['usun_z_bazy'])) {
    $nazwisko = $_POST['nazwisko'];
    $imie = $_POST['imie'];

    // Znajdź id użytkownika na podstawie nazwiska i imienia
    $select_user_id_sql = "SELECT id FROM uzytkownicy WHERE surname = '$nazwisko' AND name = '$imie'";
    $result_user_id = $polaczenie->query($select_user_id_sql);

    if ($result_user_id->num_rows > 0) {
        $row = $result_user_id->fetch_assoc();
        $user_id = $row['id'];

        // Usuń rekord z tabeli 2024 na podstawie id użytkownika
        $delete_2024_sql = "DELETE FROM `2024` WHERE `Id_user` = $user_id";
        if ($polaczenie->query($delete_2024_sql) === TRUE) {
            echo "Usunięto zawodnika z zawodów!";
        } else {
            echo "Błąd: " . $polaczenie->error;
        }

        // Usuń użytkownika z tabeli uzytkownicy
        $delete_user_sql = "DELETE FROM `uzytkownicy` WHERE `id` = $user_id";
        if ($polaczenie->query($delete_user_sql) === TRUE) {
            echo "Usunięto użytkownika z tabeli uzytkownicy!";
        } else {
            echo "Błąd: " . $polaczenie->error;
        }
    } else {
        echo "Nie znaleziono użytkownika o podanym nazwisku i imieniu.";
    }
}
if (isset($_POST['dodaj_tabele'])) {
    $nazwa_tabeli = $_POST['nazwa_tabeli'];
    
    
    $check_table_sql = "SHOW TABLES LIKE '$nazwa_tabeli'";
    $result = $polaczenie->query($check_table_sql);

    if ($result->num_rows > 0) {
        echo "Tabela o nazwie $nazwa_tabeli już istnieje!";
    } else {
     
     $create_table_sql = "CREATE TABLE IF NOT EXISTS `$nazwa_tabeli` (
                            `Numer_startowy` INT NOT NULL,
                            `Id_user` INT NOT NULL,
                            `Czas` TIME,
                            `Miejsce` INT,
                            -- Dodaj inne kolumny według potrzeb
                            PRIMARY KEY (`Numer_startowy`)
                        )";


        if ($polaczenie->query($create_table_sql) === TRUE) {
            echo "Utworzono nową tabelę: $nazwa_tabeli";
        } else {
            echo "Błąd: " . $polaczenie->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- Dodaj linki do stylów CSS i innych elementów, jak w oryginalnym kodzie -->
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
        .relative-container {
            display: flex;
            justify-content: space-around; 
            align-items: center;
            height: 100vh; 
        }

        .great{
            background-color: silver;
            padding: 15px;
             box-shadow: 0 0 80px rgba(0, 0, 0, 0.6);
        
        }        
        form {
            width: 300px; 
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
  
       <?php       
        if(isset($_SESSION['zalogowany'])) {
            echo '<a href="logout.php">Wyloguj</a>';
        } else {
            echo '<a href="logowanie.php">Logowanie</a>';
        }
        ?>
 
 
    </nav>
</header>

   <div class="napis">
<?php
echo '<div style="background-color: #16b2ff; padding: 10px; border-radius: 8px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2); text-align: center; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">';
echo '<p style="text-transform: uppercase; color: #fff; font-size: 36px; text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.8);">';
echo 'Witaj ' . $_SESSION['name'] . '!!!</p>';
echo '<p style="color: #fff;">' . $_SESSION['surname'] . '!!!</p>';
echo '</div>';
?>



    </div>
     <div class="relative-container">
  
     <div class="great">
    <form method="post" action="">
   
        <label for="nazwisko">Nazwisko:</label></br>
        <input type="text" id="nazwisko" name="nazwisko" required></br>

        <label for="imie">Imię:</label>
        </br>
        <input type="text" id="imie" name="imie" required>
        </br>
           </br>
            <button type="submit" name="usun_z_zawodow">Usuń z zawodów 2024</button>
            </br>
            </br>
            <button type="submit" name="usun_z_bazy">Usuń z bazy danych</button>

     
<!-- </form>
        </div >
        <div class="great">
       <form method="post" action="">
   
        <label for="nazwa_tabeli">Nazwa nowych zawodów:</label>
        <input type="text" id="nazwa_tabeli" name="nazwa_tabeli" required>
        <button type="submit" name="dodaj_tabele">Dodaj nową tabelę</button>
    
    </form>   
    </div>
   -->


</div>
</body>
</html>