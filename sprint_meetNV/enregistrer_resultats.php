<?php
session_start();
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

// Vérifie si l'utilisateur est connecté et est un arbitre
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header("Location: login.html");
    exit;
}

// Vérifie si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Accès non autorisé.");
}

// Récupère l'ID de la course
$course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
if ($course_id <= 0) {
    die("Erreur : Course non spécifiée.");
}

// Vérifie si les données sont complètes
if (empty($_POST['temps']) || empty($_POST['statut'])) {
    die("Erreur : Données incomplètes.");
}

// Démarre une transaction
mysqli_begin_transaction($conn);

try {
    // Pour chaque inscription, traiter le résultat
    foreach ($_POST['temps'] as $inscription_id => $temps) {
        $statut = $_POST['statut'][$inscription_id] ?? 'OK';

        // Vérifie si un résultat existe déjà pour cette inscription
        $sql = "SELECT id FROM performances WHERE inscription_id = $inscription_id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Mise à jour du résultat existant
            $sql = "UPDATE performances 
                    SET temps = '$temps', statut = '$statut' 
                    WHERE inscription_id = $inscription_id";
        } else {
            // Insertion d'un nouveau résultat
            $sql = "INSERT INTO performances (inscription_id, temps, statut) 
                    VALUES ($inscription_id, '$temps', '$statut')";
        }
        mysqli_query($conn, $sql);
    }

    // Valide la transaction
    mysqli_commit($conn);
    header("Location: dashboard_arbitre.php?message=Résultats enregistrés avec succès");
    exit;
} catch (Exception $e) {
    // Annule la transaction en cas d'erreur
    mysqli_rollback($conn);
    die("Erreur lors de l'enregistrement : " . $e->getMessage());
}
?>