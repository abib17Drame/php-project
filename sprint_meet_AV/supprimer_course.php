<?php
require_once 'includes/db_connect.php';

$id = $_GET['id'];

// Supprimer d'abord les inscriptions liées
$sql = "DELETE FROM inscriptions WHERE course_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

// Ensuite supprimer la course
$sql = "DELETE FROM courses WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header('Location: courses.php');
exit;
