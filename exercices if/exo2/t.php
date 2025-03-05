<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="traite.php" method="get">
        <fieldset style="background-color: green;">
            nom : <input type="text" name="nom">
            age : <input type="text" name="age"><br>
            <input type="submit" value="OK">
        </fieldset>
        <?php
    if(isset($_GET["nom"]) && isset($_GET["age"])) {
        $nom = ($_GET["nom"]);
        $age = ($_GET["age"]);
        echo "Bonjour " . $nom . ", vous avez " . $age . " ans";
    }
    ?>
    </form>
</body>
</html>
