<?php
require_once 'includes/db_connect.php';

// Récupérer toutes les courses disponibles
$sql = "SELECT * FROM courses WHERE date_course >= CURRENT_DATE AND statut_inscription = 'ouvert' ORDER BY date_course";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Courses Disponibles</title>
    <style>
        .course-list {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .course-list th, .course-list td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        .course-list th {
            background: #2c3e50;
            color: white;
        }
        .inscription-btn {
            padding: 5px 10px;
            background: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Courses Disponibles</h1>
    
    <table class="course-list">
        <tr>
            <th>Nom de la course</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
        <?php foreach($courses as $course): ?>
            <tr>
                <td><?= $course['nom'] ?></td>
                <td><?= $course['date_course'] ?></td>
                <td><?= $course['statut_inscription'] ?></td>
                <td>
                    <a href="scripts/register_to_course.php?course_id=<?= $course['id'] ?>" class="inscription-btn">S'inscrire</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
