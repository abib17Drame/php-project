<?php
session_start();
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

// Vérifie si l'utilisateur est connecté et est un arbitre
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header('Location: login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    
    // Pour chaque athlète, mettre à jour le temps réalisé
    foreach ($_POST['temps'] as $athlete_id => $temps) {
        if (!empty($temps)) {
            $sql = "UPDATE inscriptions 
                    SET temps_realise = '$temps' 
                    WHERE user_id = $athlete_id AND course_id = $course_id";
            mysqli_query($conn, $sql);
        }
    }
    
    // Redirige vers la page des résultats
    header("Location: consulter_resultats.php?course_id=" . $course_id);
    exit;
}
?>