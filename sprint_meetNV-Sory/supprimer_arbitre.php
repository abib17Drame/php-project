<?php
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

$id = $_GET['id'];

// Supprimer d'abord les assignations de courses
$sql = "DELETE FROM arbitrage WHERE arbitre_id = $id";
mysqli_query($conn, $sql);

// Supprimer l'arbitre
$sql = "DELETE FROM users WHERE id = $id AND role = 'arbitre'";
mysqli_query($conn, $sql);

header('Location: arbitres.php');
exit;
?>