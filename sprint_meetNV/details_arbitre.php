<?php
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

$id = $_GET['id'];

// Récupérer les informations de l'arbitre
$sql = "SELECT * FROM users WHERE id = '$id' AND role = 'arbitre'";
$result = mysqli_query($conn, $sql);
$arbitre = mysqli_fetch_assoc($result);

// Récupérer les courses assignées
$sql_courses = "SELECT c.* FROM courses c 
               JOIN arbitrage a ON c.id = a.course_id 
               WHERE a.arbitre_id = '$id'";
$result_courses = mysqli_query($conn, $sql_courses);
$courses = mysqli_fetch_all($result_courses, MYSQLI_ASSOC);
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
        <h2><?php echo $arbitre['prenom'] . ' ' . $arbitre['nom']; ?></h2>
        <p>Email: <?php echo $arbitre['email']; ?></p>
        <p>Identifiant: <?php echo $arbitre['identifiant']; ?></p>
        <?php if ($arbitre['fichier_certif']): ?>
            <p>Certification: <a href="certifications/<?php echo $arbitre['fichier_certif']; ?>">Voir le fichier</a></p>
        <?php endif; ?>
    </div>

    <h2>Courses assignées</h2>
    <table class="courses-table">
        <tr>
            <th>Course</th>
            <th>Date</th>
        </tr>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo $course['nom']; ?></td>
                <td><?php echo $course['date_course']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="arbitres.php">Retour à la liste</a>
</body>
</html>