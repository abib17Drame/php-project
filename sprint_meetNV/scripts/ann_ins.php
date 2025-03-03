<?php
session_start();
require_once '../includes/db_connect.php';

// Vérifie si l'utilisateur est connecté et est un athlète
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: ../login.html");
    exit;
}

// Récupère l'ID de la course depuis l'URL
$course_id = $_GET['course_id'];
if (empty($course_id)) {
    header("Location: ../dashboard_athlete.html?message=course_missing");
    exit;
}

// Requête SQL pour annuler l'inscription
$user_id = $_SESSION['user_id'];
$sql = "DELETE FROM inscriptions WHERE user_id = '$user_id' AND course_id = '$course_id'";

// Exécute la requête
if (mysqli_query($conn, $sql)) {
    header("Location: ../scripts/mescourses.php?message=Inscription annulée");
} else {
    header("Location: ../scripts/mescourses.php?message=Erreur d'annulation");
}
exit;
?>