<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
</head>
<body>
    
    <?php
        function formulaire($name, $age){ 
            ?>
            <form action="exo3.php" method="post">
            <label for="nom">Nom: </label>
            <input type="text" name="nom" id="nom" value="<?php echo $name; ?>"><br>
            <label for="age">Age: </label>
            <input type="number" name="age" id="age" value="<?php echo $age; ?>"><br>
            <input type="submit" value="OK">
            </form>
    <?php }

        function traitement($name, $age){
            if ($age >= 18) {
                $message = "Bonjour ".$name." votre âge est ".$age;
                echo $message;
            }
            else{
                echo "L'âge doit être supérieur à 18.<br><br>";
                formulaire($name, "");
            }
        }

        if(!isset($_REQUEST["nom"]) || !isset($_REQUEST["age"])) 
            formulaire("", "");
        else 
            traitement($_REQUEST["nom"], $_REQUEST["age"]);
    ?>
</body>
</html>