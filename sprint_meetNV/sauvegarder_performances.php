<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header('Location: login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    
    foreach ($_POST['temps'] as $athlete_id => $temps) {
        if (!empty($temps)) {
            $sql = "UPDATE inscriptions 
                    SET temps_realise = ? 
                    WHERE user_id = ? AND course_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$temps, $athlete_id, $course_id]);
        }
    }
    
    header("Location: consulter_resultats.php?course_id=" . $course_id);
    exit;
}
