<?php
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire
    $arbitre_id = $_POST['arbitre_id'];
    $course_id = $_POST['course_id'];

    // Requête SQL pour assigner un arbitre à une course
    $sql = "INSERT INTO arbitrage (arbitre_id, course_id) VALUES ('$arbitre_id', '$course_id')";

    // Exécute la requête
    if (mysqli_query($conn, $sql)) {
        // Redirige vers la page des détails de l'arbitre
        header("Location: details_arbitre.php?id=" . $arbitre_id);
        exit;
    } else {
        // Affiche une erreur si la requête échoue
        echo "Erreur : " . mysqli_error($conn);
    }
}
?>