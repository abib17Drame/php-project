<?php
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

$id = $_GET['id'];

// Basculer le statut d'inscription de la course
$sql = "UPDATE courses SET statut_inscription = 
        CASE 
            WHEN statut_inscription = 'ouvert' THEN 'fermé'
            ELSE 'ouvert'
        END 
        WHERE id = $id";
mysqli_query($conn, $sql);

header('Location: courses.php');
exit;
?>