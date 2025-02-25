<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header('Location: login.html');
    exit;
}

if (!isset($_GET['course_id'])) {
    header('Location: dashboard_arbitre.php');
    exit;
}
$course_id = $_GET['course_id'];

// Récupérer les informations de la course
$sql = "SELECT * FROM courses WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$course_id]);
$course = $stmt->fetch();

if (!$course) {
    header('Location: dashboard_arbitre.php');
    exit;
}

// Récupérer les résultats
$sql = "SELECT u.nom, u.prenom, i.temps_realise 
        FROM users u 
        INNER JOIN inscriptions i ON u.id = i.user_id 
        WHERE i.course_id = ? 
        ORDER BY i.temps_realise";
$stmt = $pdo->prepare($sql);
$stmt->execute([$course_id]);
$resultats = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats de la Course</title>
    <style>
        .resultats-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .resultats-table th, .resultats-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .resultats-table th {
            background: #2c3e50;
            color: white;
        }
        .btn-modifier {
            background: #3498db;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Résultats : <?= htmlspecialchars($course['nom']) ?></h1>
    
    <table class="resultats-table">
        <tr>
            <th>Position</th>
            <th>Athlète</th>
            <th>Temps</th>
        </tr>
        <?php 
        $position = 1;
        foreach($resultats as $resultat): 
        ?>
            <tr>
                <td><?= $position++ ?></td>
                <td><?= htmlspecialchars($resultat['prenom'] . ' ' . $resultat['nom']) ?></td>
                <td><?= $resultat['temps_realise'] ?: 'Non enregistré' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
    <a href="noter_performances.php?course_id=<?= $course_id ?>" class="btn-modifier">Modifier les résultats</a>
    <a href="dashboard_arbitre.php">Retour au tableau de bord</a>
</body>
</html>
