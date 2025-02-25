<?php
require_once 'includes/db_connect.php';

$id = $_GET['id'];

// Supprimer d'abord les performances
$sql = "DELETE FROM performances WHERE inscription_id IN (SELECT id FROM inscriptions WHERE user_id = $id)";
$pdo->query($sql);

// Ensuite supprimer les inscriptions
$sql = "DELETE FROM inscriptions WHERE user_id = $id";
$pdo->query($sql);

// Enfin supprimer l'athlète
$sql = "DELETE FROM users WHERE id = $id AND role = 'athlete'";
$pdo->query($sql);

header('Location: athletes.php');
exit;
?>
