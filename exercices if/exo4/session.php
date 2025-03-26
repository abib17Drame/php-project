<?php
    define('MAX_TEMPS_INACTIF', 10);
    session_start();    
    if(!isset($_SESSION['visites'])){
        $_SESSION['visites'] = 1;
        $_SESSION['t'] = time();
    }else{
        if(time() - $_SESSION['t'] > MAX_TEMPS_INACTIF){
            session_destroy();
            die("Session expirée ");
        }
        $_SESSION['visites']++;
        $_SESSION['t'] = time();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nombre de visites</title>
</head>
<body>
    <form action="session.php">
        <input type="submit" value="Continuer"> avant 10 secondes
    </form>
</body>
</html>