<?php
require_once '../includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Arbitre - Sprint Meet</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2980b9; /* Bleu élégant */
            --secondary-red: #e74c3c; /* Rouge vibrant */
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
            max-width: 800px;
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

        /* Section des informations */
        .info-box {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin: 20px 0;
        }
        .info-box h2 {
            color: var(--primary-blue);
            margin-bottom: 15px;
        }
        .info-box p {
            margin: 10px 0;
            color: #444;
        }
        .info-box a {
            color: var(--primary-blue);
            text-decoration: none;
        }
        .info-box a:hover {
            text-decoration: underline;
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
            body {
                padding: 10px;
            }
            h1 {
                font-size: 1.5rem;
            }
            .info-box, .courses-table {
                padding: 15px;
            }
            .courses-table th, .courses-table td {
                padding: 8px;
                font-size: 0.9rem;
            }
            .retour {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Détails de l'arbitre</h1>
    </header>

    <div class="info-box">
        <h2><?php echo htmlspecialchars($arbitre['prenom'] . ' ' . $arbitre['nom']); ?></h2>
        <p><strong>Email :</strong> <?php echo htmlspecialchars($arbitre['email']); ?></p>
        <p><strong>Identifiant :</strong> <?php echo htmlspecialchars($arbitre['identifiant']); ?></p>
        <?php if ($arbitre['fichier_certif']): ?>
            <p><strong>Certification :</strong> <a href="certifications/<?php echo htmlspecialchars($arbitre['fichier_certif']); ?>" target="_blank">Voir le fichier</a></p>
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
                <td><?php echo htmlspecialchars($course['nom']); ?></td>
                <td><?php echo htmlspecialchars($course['date_course']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="arbitres.php" class="retour">Retour à la liste</a>
</body>
</html>