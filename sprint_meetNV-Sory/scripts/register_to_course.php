<?php
session_start();
require_once '../includes/db_connect.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$course_id = $_GET['course_id'];

// Vérifie si les inscriptions sont ouvertes
$sql = "SELECT nom, statut_inscription FROM courses WHERE id = '$course_id'";
$result = mysqli_query($conn, $sql);
$course = mysqli_fetch_assoc($result);

if ($course['statut_inscription'] == 'fermé') {
    $_SESSION['message'] = "Les inscriptions sont fermées pour la course " . $course['nom'];
    header("Location: ../dashboard_athlete.html");
    exit;
}

// Vérifie si l'utilisateur est déjà inscrit
$sql = "SELECT COUNT(*) FROM inscriptions WHERE user_id = '$user_id' AND course_id = '$course_id'";
$result = mysqli_query($conn, $sql);
$count = mysqli_fetch_row($result)[0];

if ($count > 0) {
    echo "<script>
        alert('Vous êtes déjà inscrit à cette course');
        window.location.href='../dashboard_athlete.html';
    </script>";
    exit;
}

// Inscription à la course
$sql = "INSERT INTO inscriptions (user_id, course_id, date_inscription) VALUES ('$user_id', '$course_id', NOW())";
if (mysqli_query($conn, $sql)) {
    $_SESSION['message'] = "Inscription réussie à la course " . $course['nom'];
} else {
    $_SESSION['message'] = "Erreur lors de l'inscription";
}

header("Location: ../dashboard_athlete.html");
exit;
?>