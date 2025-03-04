<?php
require_once 'includes/db_connect.php'; // Connexion à la base de données

// Récupération des courses
$sql = "SELECT * FROM courses ORDER BY date_course DESC";
$result = mysqli_query($conn, $sql);
$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Courses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .course-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .course-table th, .course-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        .course-table th {
            background: #2c3e50;
            color: white;
        }
        .btn {
            padding: 8px 15px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 0 5px;
        }
        .btn-add { background: #27ae60; }
        .btn-edit { background: #3498db; }
        .btn-delete { background: #e74c3c; }
        .btn-view { background: #f39c12; }
        .btn-assign { background: #8e44ad; }
        .add-course {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Gestion des Courses</h1>

    <div class="add-course">
        <a href="add_course.php" class="btn btn-add">Ajouter une course</a>
    </div>

    <table class="course-table">
        <tr>
            <th>Nom</th>
            <th>Date</th>
            <th>Statut Inscriptions</th>
            <th>Nombre d'inscrits</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($courses as $course): 
            $sql_count = "SELECT COUNT(*) FROM inscriptions WHERE course_id = " . $course['id'];
            $count_result = mysqli_query($conn, $sql_count);
            $count = mysqli_fetch_row($count_result)[0];
        ?>
            <tr>
                <td><?php echo $course['nom']; ?></td>
                <td><?php echo $course['date_course']; ?></td>
                <td><?php echo $course['statut_inscription']; ?></td>
                <td><?php echo $count; ?></td>
                <td>
                    <a href="modifier_course.php?id=<?php echo $course['id']; ?>" class="btn btn-edit">Modifier</a>
                    <a href="supprimer_course.php?id=<?php echo $course['id']; ?>" class="btn btn-delete">Supprimer</a>
                    <a href="inscrits_course.php?id=<?php echo $course['id']; ?>" class="btn btn-view">Voir inscrits</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
