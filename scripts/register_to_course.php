<?php
session_start();
require_once '../includes/db_connect.php';

// Vérifier que l'utilisateur est connecté et qu'il est un athlète
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: ../login.html");
    exit;
}

// Récupérer l'ID de la course depuis l'URL
$course_id = $_GET['course_id'] ?? null;
if (!$course_id) {
    header("Location: ../scripts/choose_course.php?error=course_missing");
    exit;
}

try {
    // Vérifier si l'athlète est déjà inscrit à cette course
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM inscriptions WHERE user_id = :user_id AND course_id = :course_id");
    $stmt->execute([
        ':user_id' => $_SESSION['user_id'],
        ':course_id' => $course_id
    ]);
    
    if ($stmt->fetchColumn() > 0) {
        // S'il est déjà inscrit, rediriger vers la page listant ses inscriptions
        header("Location: ../scripts/my_registrations.php?message=already_registered");
        exit;
    }
    
    // Inscrire l'athlète à la course
    $stmt = $pdo->prepare("INSERT INTO inscriptions (user_id, course_id, date_inscription) VALUES (:user_id, :course_id, CURDATE())");
    if ($stmt->execute([
        ':user_id' => $_SESSION['user_id'],
        ':course_id' => $course_id
    ])) {
        header("Location: ../dashboard_athlete.html?message=registration_successful");
        exit;
    } else {
        header("Location: ../dashboard_athlete.html?message=registration_error");
        exit;
    }
} catch (PDOException $e) {
    error_log("Erreur lors de l'inscription à la course : " . $e->getMessage());
    header("Location: ../dashboard_athlete.html?message=registration_error");
    exit;
}
?>
