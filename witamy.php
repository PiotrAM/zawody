<?php

session_start();

if(!isset($_SESSION['udanarejestracja']))
{

header('Location:index.php');
exit();
}
else{
    unset($_SESSION['udanarejestracja']);
}
?>


<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>

    <link rel="stylesheet" href="styl.css">

    <meta charset="utf-8" />
    <title>Zawody</title>
</head>
<body>

Dziękujemy za rejestrację w serwisie, możesz zalogować się na swoje konto!<br /> <br />

    <a href="index.php"> Zaloguj się na swoje konto!></a>

    <br/><br/>



  

</body>
</html>