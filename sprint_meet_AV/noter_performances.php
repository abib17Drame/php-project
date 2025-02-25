<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header('Location: login.html');
    exit;
}

// Vérification et récupération de l'ID de la course
if (!isset($_GET['course_id'])) {
    header('Location: dashboard_arbitre.php');
    exit;
}
$course_id = $_GET['course_id'];

// Récupération des informations de la course
$sql = "SELECT * FROM courses WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$course_id]);
$course = $stmt->fetch();

// Récupération des athlètes inscrits
$sql = "SELECT u.*, i.temps_realise 
        FROM users u 
        INNER JOIN inscriptions i ON u.id = i.user_id 
        WHERE i.course_id = ? AND u.role = 'athlete'
        ORDER BY i.temps_realise";
$stmt = $pdo->prepare($sql);
$stmt->execute([$course_id]);
$athletes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Noter les Performances</title>
    <style>
        .performance-form {
            max-width: 800px;
            margin: 20px auto;
        }
        .athlete-row {
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .form-group {
            margin: 10px 0;
        }
        .btn-save {
            background: #27ae60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Noter les Performances - <?= htmlspecialchars($course['nom']) ?></h1>
    
    <form class="performance-form" method="POST" action="sauvegarder_performances.php">
        <input type="hidden" name="course_id" value="<?= $course_id ?>">
        <?php foreach($athletes as $athlete): ?>
            <div class="athlete-row">
                <h3><?= htmlspecialchars($athlete['prenom'] . ' ' . $athlete['nom']) ?></h3>
                <div class="form-group">
                    <label>Temps réalisé (format: MM:SS.ms) :</label>
                    <input type="text" name="temps[<?= $athlete['id'] ?>]" 
                           value="<?= $athlete['temps_realise'] ?>" 
                           pattern="[0-9]{2}:[0-9]{2}.[0-9]{2}">
                </div>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn-save">Sauvegarder les résultats</button>
    </form>
    
    <a href="dashboard_arbitre.php">Retour au tableau de bord</a>
</body>
</html>
