<?php
require_once 'includes/db_connect.php';

$id = $_GET['id'];

// Récupérer les informations de la course
$sql = "SELECT * FROM courses WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$course = $stmt->fetch();

// Récupérer les inscrits
$sql = "SELECT u.* FROM users u 
        JOIN inscriptions i ON u.id = i.user_id 
        WHERE i.course_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$inscrits = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscrits à la Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .inscrits-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .inscrits-table th, .inscrits-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        .inscrits-table th {
            background: #2c3e50;
            color: white;
        }
        h1, h2 {
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <h1>Inscrits à la course : <?= $course['nom'] ?></h1>
    <h2>Date : <?= $course['date_course'] ?></h2>

    <table class="inscrits-table">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Profil</th>
        </tr>
        <?php foreach($inscrits as $inscrit): ?>
            <tr>
                <td><?= $inscrit['nom'] ?></td>
                <td><?= $inscrit['prenom'] ?></td>
                <td><?= $inscrit['email'] ?></td>
                <td><?= $inscrit['profil'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="courses.php">Retour à la liste des courses</a>
</body>
</html>
