<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$course_id = $_GET['course_id'];

// Vérification du statut de la course
$sql = "SELECT nom, statut_inscription FROM courses WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$course_id]);
$course = $stmt->fetch();

if ($course['statut_inscription'] == 'fermé') {
    $_SESSION['message'] = "Les inscriptions sont fermées pour la course " . $course['nom'];
    header("Location: ../dashboard_athlete.html");
    exit;
}

// Vérification si déjà inscrit
$sql = "SELECT COUNT(*) FROM inscriptions WHERE user_id = ? AND course_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $course_id]);

if ($stmt->fetchColumn() > 0) {
    echo "<script>
        alert('Vous êtes déjà inscrit à cette course');
        window.location.href='../dashboard_athlete.html';
    </script>";
    exit;
}

// Inscription
$sql = "INSERT INTO inscriptions (user_id, course_id, date_inscription) VALUES (?, ?, NOW())";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$user_id, $course_id])) {
    $_SESSION['message'] = "Inscription réussie à la course " . $course['nom'];
} else {
    $_SESSION['message'] = "Erreur lors de l'inscription";
}

header("Location: ../dashboard_athlete.html");
exit;
?>
