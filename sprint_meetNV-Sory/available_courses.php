<?php
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

// Récupérer toutes les courses disponibles
$sql = "SELECT * FROM courses WHERE date_course >= CURRENT_DATE AND statut_inscription = 'ouvert' ORDER BY date_course";
$result = mysqli_query($conn, $sql);
$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo $course['nom']; ?></td>
                <td><?php echo $course['date_course']; ?></td>
                <td><?php echo $course['statut_inscription']; ?></td>
                <td>
                    <a href="scripts/register_to_course.php?course_id=<?php echo $course['id']; ?>" class="inscription-btn">S'inscrire</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>