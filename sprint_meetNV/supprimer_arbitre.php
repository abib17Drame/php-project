<?php
require_once 'includes/db_connect.php';

$id = $_GET['id'];

// Supprimer d'abord les assignations de courses
$sql = "DELETE FROM arbitrage WHERE arbitre_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

// Supprimer l'arbitre
$sql = "DELETE FROM users WHERE id = ? AND role = 'arbitre'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header('Location: arbitres.php');
exit;
