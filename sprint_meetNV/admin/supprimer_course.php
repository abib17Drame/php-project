<?php
require_once '../includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

$id = $_GET['id'];

// Supprimer d'abord les inscriptions liées
$sql = "DELETE FROM inscriptions WHERE course_id = $id";
mysqli_query($conn, $sql);

// Ensuite supprimer la course
$sql = "DELETE FROM courses WHERE id = $id";
mysqli_query($conn, $sql);

header('Location: courses.php');
exit;
?>