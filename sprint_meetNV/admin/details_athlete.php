<?php
require_once '../includes/db_connect.php'; 

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Athlète - Sprint Meet</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2980b9; /* Bleu principal */
            --secondary-red: #e74c3c; /* Rouge secondaire */
            --white: #fff;
            --black: #000;
        }

        /* Styles généraux */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--white);
            color: var(--black);
            text-align: center;
            min-height: 100vh;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* En-tête */
        header {
            background: linear-gradient(90deg, var(--primary-blue), var(--secondary-red));
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            color: var(--white);
        }
        h1 {
            font-size: 2rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }

        /* Section des informations de l'athlète */
        .info-athlete {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .info-athlete h2 {
            color: var(--primary-blue);
            margin-bottom: 20px;
        }
        .info-athlete p {
            margin: 10px 0;
            color: #444;
        }

        /* Tableau des courses */
        .courses-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .courses-table th, .courses-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .courses-table th {
            background-color: var(--primary-blue);
            color: var(--white);
        }
        .courses-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .courses-table tr:hover {
            background-color: #e0e7ff;
        }

        /* Bouton Retour */
        .retour {
            display: inline-block;
            padding: 12px 25px;
            background: var(--primary-blue);
            color: var(--white);
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .retour:hover {
            background: var(--secondary-red);
            transform: translateY(-3px);
        }

        /* Design responsive */
        @media (max-width: 600px) {
            .info-athlete, .courses-table {
                padding: 10px;
            }
            h1 {
                font-size: 1.5rem;
            }
            .retour {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Détails de l'athlète</h1>
    </header>

    <div class="info-athlete">
        <h2><?php echo $athlete['prenom'] . ' ' . $athlete['nom']; ?></h2>
        <p><strong>Email :</strong> <?php echo $athlete['email']; ?></p>
        <p><strong>Profil :</strong> <?php echo $athlete['profil']; ?></p>
        <p><strong>Genre :</strong> <?php echo $athlete['sexe']; ?></p>
        <p><strong>Record :</strong> <?php echo $athlete['record_officiel']; ?></p>
    </div>

    <h2>Courses inscrites</h2>
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

    <a href="athletes.php" class="retour">Retour à la liste</a>
</body>
</html>