<?php
$host = 'localhost';  // Adresse du serveur de base de données
$db   = 'sprint_meet'; // Nom de la base de données
$user = 'root';       // Nom d'utilisateur de la base de données
$pass = '';           // Mot de passe de la base de données

// Connexion à la base de données
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}
?>