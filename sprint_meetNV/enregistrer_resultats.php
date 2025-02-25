<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Accès non autorisé.");
}

$course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
if ($course_id <= 0) {
    die("Erreur : Course non spécifiée.");
}

if (empty($_POST['temps']) || empty($_POST['statut'])) {
    die("Erreur : Données incomplètes.");
}

try {
    $pdo->beginTransaction();
    
    // Pour chaque inscription, traiter le résultat
    foreach ($_POST['temps'] as $inscription_id => $temps) {
        $statut = $_POST['statut'][$inscription_id] ?? 'OK';

        // Vérifier si un résultat existe déjà pour cette inscription
        $stmt = $pdo->prepare("SELECT id FROM performances WHERE inscription_id = :inscription_id");
        $stmt->execute([':inscription_id' => $inscription_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Mise à jour du résultat existant
            $stmt = $pdo->prepare("
                UPDATE performances 
                SET temps = :temps, statut = :statut 
                WHERE inscription_id = :inscription_id
            ");
        } else {
            // Insertion d'un nouveau résultat
            $stmt = $pdo->prepare("
                INSERT INTO performances (inscription_id, temps, statut) 
                VALUES (:inscription_id, :temps, :statut)
            ");
        }
        $stmt->execute([
            ':inscription_id' => $inscription_id,
            ':temps' => $temps,
            ':statut' => $statut
        ]);
    }
    
    $pdo->commit();
    header("Location: dashboard_arbitre.php?message=Résultats enregistrés avec succès");
    exit;
} catch (PDOException $e) {
    $pdo->rollBack();
    die("Erreur lors de l'enregistrement : " . $e->getMessage());
}
?>
