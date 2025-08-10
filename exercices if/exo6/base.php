<html>
<head>
<title>Liens</title>
</head>
<body>
<table border="1" cellpadding="0" cellspacing="0">
<tr>
<th>Nom du site</th>
<th>URL</th>
</tr>
<?php
// Déclaration des paramètres de connexion
$host = "localhost";
// Généralement la machine est localhost
// c'est-a-dire la machine sur laquelle le script est hébergé
$user = "root";
$bdd = "Messites";
$passwd = "";

// Connexion au serveur
$conn = mysqli_connect($host, $user, $passwd, $bdd) or die("erreur de connexion au serveur ou à la base de données");

// Creation et envoi de la requete
$query = "SELECT nom, url FROM site ORDER BY nom";
$result = mysqli_query($conn, $query);

// Recuperation des resultats
while ($row = mysqli_fetch_row($result)) {
    $Nom = $row[0];
    $Url = $row[1];
    echo "<tr>\n
    <td><a href=\"$Url\">$Nom</a></td>\n
    <td>$Url</td>\n
    </tr>\n";
}

// Deconnexion de la base de donnees
mysqli_close($conn);
?>
</tr>
</table>
</body>
</html>