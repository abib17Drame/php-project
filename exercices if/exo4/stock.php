<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .r{
            background-color:red;
        }
    </style>
</head>
<body>
    
</body>
</html>
<?php
    echo "Nom du fichier Original: ".$_FILES["monfichier"]['name']."<br>";
    echo "Emplacement temporaire : ".$_FILES["monfichier"]['tmp_name']."<br>";
    echo "Taille du fichier Original: ".$_FILES["monfichier"]['size']." octets<br><br>";
    move_uploaded_file($_FILES["monfichier"]["tmp_name"], "../fichier_televerse/" . $_FILES["monfichier"]["name"]);
    $nomorigin  = $_FILES["monfichier"]["name"];

    if (!($fichier = fopen("../fichier_televerse/$nomorigin", "r"))) {
        die("Probleme d'ouverture du fichier");
    }
    while (!feof($fichier)) {
        $ligne = fgets($fichier,255);
        $motif = $_POST["motif"]; 
        $ligne = str_replace($motif , "<span class='r'>".$motif."</span>",$ligne);
        echo $ligne . "<br>";
    }
    fclose($fichier);
?>

    