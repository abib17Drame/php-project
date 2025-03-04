<?php
require_once 'includes/db_connect.php';

// Récupération des courses
$sql = "SELECT id, nom, course_type, date_course, statut_inscription 
        FROM courses 
        ORDER BY date_course DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Courses disponibles - Sprint Meet</title>
    <style>
        .d {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .carte_cou {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .titre_course {
            color: #333;
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .course-info {
            color: #666;
            margin-bottom: 15px;
        }

        .inscription-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        .inscription-btn:hover {
            background: #1976D2;
        }

        .statut-ferme {
            background: #666;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <h1>Courses Disponibles</h1>

    <div class="d">
        <?php while($course = mysqli_fetch_assoc($result)): ?>
            <div class="carte_cou">
                <div class="titre_course">
                    <?php echo $course['nom']; ?>
                </div>
                <div class="course-info">
                    <p>Type: <?php echo $course['course_type']; ?></p>
                    <p>Date: <?php echo $course['date_course']; ?></p>
                    <p>Statut: <?php echo $course['statut_inscription']; ?></p>
                </div>
                <?php if($course['statut_inscription'] == 'ouvert'): ?>
                    <a href="scripts/choix_course.php" class="inscription-btn">S'inscrire</a>
                <?php else: ?>
                    <a class="inscription-btn statut-ferme">Inscriptions fermées</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
