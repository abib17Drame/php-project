<?php
require_once '../includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

$id = $_GET['id'];

// Supprimer d'abord les performances
$sql = "DELETE FROM performances WHERE inscription_id IN (SELECT id FROM inscriptions WHERE user_id = $id)";
mysqli_query($conn, $sql);

// Ensuite supprimer les inscriptions
$sql = "DELETE FROM inscriptions WHERE user_id = $id";
mysqli_query($conn, $sql);

// Enfin supprimer l'athlète
$sql = "DELETE FROM users WHERE id = $id AND role = 'athlete'";
mysqli_query($conn, $sql);

header('Location: athletes.php');
exit;
?>