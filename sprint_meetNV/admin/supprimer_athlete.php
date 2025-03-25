<?php
require_once '../includes/db_connect.php';

$id = $_GET['id'];

// Supprim  les performances d'abord 
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