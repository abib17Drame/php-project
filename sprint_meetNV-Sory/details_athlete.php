<?php
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

$id = $_GET['id'];

// Récupérer les informations de l'athlète
$sql = "SELECT * FROM users WHERE id = $id AND role = 'athlete'";
$result = mysqli_query($conn, $sql);
$athlete = mysqli_fetch_assoc($result);

// Récupérer les courses auxquelles l'athlète est inscrit
$sql_courses = "SELECT c.nom, c.date_course 
                FROM courses c 
                JOIN inscriptions i ON c.id = i.course_id 
                WHERE i.user_id = $id";
$result_courses = mysqli_query($conn, $sql_courses);
$courses = mysqli_fetch_all($result_courses, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails Athlète</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        .info-athlete {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .info-athlete h2 {
            color: #34495e;
            margin-bottom: 20px;
        }

        .info-athlete p {
            margin: 10px 0;
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }

        a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <h1>Détails de l'athlète</h1>
    
    <div class="info-athlete">
        <h2><?php echo $athlete['prenom'] . ' ' . $athlete['nom']; ?></h2>
        <p>Email: <?php echo $athlete['email']; ?></p>
        <p>Profil: <?php echo $athlete['profil']; ?></p>
        <p>Genre: <?php echo $athlete['sexe']; ?></p>
        <p>Record: <?php echo $athlete['record_officiel']; ?></p>
    </div>

    <h2>Courses inscrites</h2>
    <table border="1">
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

    <a href="athletes.php">Retour à la liste</a>
</body>
</html>