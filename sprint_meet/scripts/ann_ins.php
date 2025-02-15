<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: ../login.html");
    exit;
}

$course_id = $_GET['course_id'] ?? null;
if (!$course_id) {
    header("Location: ../dashboard_athlete.html?message=course_missing");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM inscriptions WHERE user_id = :user_id AND course_id = :course_id");
    if ($stmt->execute([
        ':user_id' => $_SESSION['user_id'],
        ':course_id' => $course_id
    ])) {
        header("Location: ../scripts/mescourses.php?message=");
        exit;
    } else {
        header("Location: ../scripts/mescourses.php?message=Erreur d'annulation");
        exit;
    }
} catch (PDOException $e) {
    error_log("Erreur lors de l'annulation de l'inscription : " . $e->getMessage());
    header("Location: ../scripts/mescourses.php?message=Erreur d'annulation");
    exit;
}
?>
