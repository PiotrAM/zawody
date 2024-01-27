<?php

session_start();

if(isset($_POST['email']))
{
    $wszystko_OK=true;

    $login=$_POST['login'];

    if((strlen($login)<3) || (strlen($login)>20))
    {
        $wszystko_OK=false;
        $_SESSION['e_login']="Login musi posiadać od 3 do 20 znaków!";
    }


     if(ctype_alnum($login)==false)
    {
        $wszystko_OK=false;
        $_SESSION['e_login']="Login może składać się tylko z liter i cyfr!";
    }


    $email=$_POST['email'];
    $emailB=filter_var($email, FILTER_SANITIZE_EMAIL);


     if((filter_var($emailB,FILTER_SANITIZE_EMAIL)==false) || ($emailB!=$email))
    {
        $wszystko_OK=false;
        $_SESSION['e_email']="Niepoprawny e-mail!";
    }

      $name=$_POST['name'];

    if((strlen($name)<3) || (strlen($name)>20))
    {
        $wszystko_OK=false;
        $_SESSION['e_name']="Imie musi posiadać od 3 do 20 znaków!";
    }
       $surname=$_POST['surname'];

    if((strlen($name)<3) || (strlen($name)>20))
    {
        $wszystko_OK=false;
        $_SESSION['e_surname']="Nazwisko musi posiadać od 3 do 20 znaków!";
    }



    $haslo1=$_POST['haslo1'];
    $haslo2=$_POST['haslo2'];
    
    if((strlen($haslo1)<8) || (strlen($haslo1)>20))
    {
        $wszystko_OK=false;
        $_SESSION['e_haslo']="Haslo musi posiadać od 8 do 20 znaków!";
    }
      if($haslo1!=$haslo2)
    {
        $wszystko_OK=false;
        $_SESSION['e_haslo']="Podane hasła nie są identyczne!";
    }
    
   

    $haslo_hash=password_hash($haslo1, PASSWORD_DEFAULT);
    if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}	
    
        $sekret="6LcTZOAoAAAAAEJMGcaK4Go5IhG8HA27r6WijwYe";

        $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}	

        require_once "connect.php"; //połączenie bazy
        mysqli_report(MYSQLI_REPORT_STRICT); //wyjątki nie ostrzeżenia

        try
        {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
            {
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
                
                if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}	

                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$login'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_loginow = $rezultat->num_rows;
				if($ile_takich_loginow>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_login']="Istnieje już iżytkownik o takim loginie! Wybierz inny.";
				}

                if($wszystko_OK==true)
                {
               
                if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$login', '$haslo_hash', '$email', '0', '$name', '$surname')"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: witamy.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}


                }

                $polaczenie->close();
            }
        }
        catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
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
    <title>Zawody - załóż konto</title>
    <script src="https://www.google.com/recaptcha/api.js"></script>
   
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
            <h1>   REJESTRACJA      </h1>
    <br/>
    </div>
   
    <form method="post">

     <div class="input-field">
        <input type="text" class="input" placeholder="Login" name="login" /> <br />
         </div>
        <?php

        if(isset($_SESSION['e_login']))
        {

        echo '<div class="error">'.$_SESSION['e_login'].'</div>';
        unset($_SESSION['e_login']);

        }
        ?>
         <div class="input-field">
         <input type="text" class="input" placeholder="E-mail" name="email" /> <br />

         <?php

        if(isset($_SESSION['e_email']))
        {

        echo '<div class="error">'.$_SESSION['e_email'].'</div>';
        unset($_SESSION['e_email']);

        }
        ?>
         </div>
         <div class="input-field">
         <input type="text" class="input" placeholder="Imię" name="name" /> <br />
        <?php

        if(isset($_SESSION['e_name']))
        {

        echo '<div class="error">'.$_SESSION['e_name'].'</div>';
        unset($_SESSION['e_name']);

        }
        ?>
         </div>
         <div class="input-field">
         <input type="text" class="input" placeholder="Nazwisko" name="surname" /> <br />
        <?php

        if(isset($_SESSION['e_surname']))
        {

        echo '<div class="error">'.$_SESSION['e_surname'].'</div>';
        unset($_SESSION['e_surname']);

        }
        ?>
         </div>
         <div class="input-field">

        <input type="password" class="input" placeholder="Hasło" name="haslo1" /> <br />
        <?php

        if(isset($_SESSION['e_haslo']))
        {

        echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
        unset($_SESSION['e_haslo']);

        }
        ?>
         </div>
         <div class="input-field">
         <input type="password" class="input" placeholder="Powtórz hasło" name="haslo2" /> <br />

        <label>
        <input type="checkbox" name="regulamin" /> Akceptuję regulamin<br /><br />
        <label>
         <?php

        if(isset($_SESSION['e_regulamin']))
        {

        echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
        unset($_SESSION['e_regulamin']);

        }
        ?>
             </div>
    
       
        <div class="g-recaptcha" data-sitekey="6LcTZOAoAAAAAOPeqSolmOPhNQTrDZciBEr_YpNi"></div>
          <?php

        if(isset($_SESSION['e_bot']))
        {

        echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
        unset($_SESSION['e_bot']);

        }
        ?>
        <br />


        <input type="submit" class="submit" value="Zarejestruj się" />


    </form>

  </div>

</body>
</html>