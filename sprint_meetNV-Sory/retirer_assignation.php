<?php
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

$arbitre_id = $_GET['arbitre_id'];
$course_id = $_GET['course_id'];

// Supprimer l'assignation
$sql = "DELETE FROM arbitrage WHERE arbitre_id = $arbitre_id AND course_id = $course_id";
if (mysqli_query($conn, $sql)) {
    header("Location: details_arbitre.php?id=" . $arbitre_id);
    exit;
} else {
    echo "Erreur : " . mysqli_error($conn);
}
?>