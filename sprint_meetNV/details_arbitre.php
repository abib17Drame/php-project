<?php
require_once 'includes/db_connect.php';

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = ? AND role = 'arbitre'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$arbitre = $stmt->fetch();

// Récupérer les courses assignées
$sql_courses = "SELECT c.* FROM courses c 
               JOIN arbitrage a ON c.id = a.course_id 
               WHERE a.arbitre_id = ?";
$stmt_courses = $pdo->prepare($sql);
$stmt_courses->execute([$id]);
$courses = $stmt_courses->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails Arbitre</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 0 auto; padding: 20px; }
        .info-box { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .courses-table { width: 100%; border-collapse: collapse; }
        .courses-table th, .courses-table td { padding: 10px; border: 1px solid #ddd; }
        .courses-table th { background: #2c3e50; color: white; }
    </style>
</head>
<body>
    <h1>Détails de l'arbitre</h1>
    
    <div class="info-box">
        <h2><?= $arbitre['prenom'] . ' ' . $arbitre['nom'] ?></h2>
        <p>Email: <?= $arbitre['email'] ?></p>
        <p>Identifiant: <?= $arbitre['identifiant'] ?></p>
        <?php if($arbitre['fichier_certif']): ?>
            <p>Certification: <a href="certifications/<?= $arbitre['fichier_certif'] ?>">Voir le fichier</a></p>
        <?php endif; ?>
    </div>

    <h2>Courses assignées</h2>
    <table class="courses-table">
        <tr>
            <th>Course</th>
            <th>Date</th>
        </tr>
        <?php foreach($courses as $course): ?>
            <tr>
                <td><?= $course['nom'] ?></td>
                <td><?= $course['date_course'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="arbitres.php">Retour à la liste</a>
</body>
</html>
