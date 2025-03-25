<?php
session_start();
require_once '../includes/db_connect.php'; // Connexion à la base de données

// Vérification de la connexion et du rôle d'arbitre
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header('Location: login.html');
    exit;
}

// Récupération des courses arbitrées
$arbitre_id = $_SESSION['user_id'];
$sql = "SELECT c.*, COUNT(i.user_id) as nb_participants 
        FROM courses c 
        INNER JOIN arbitrage a ON c.id = a.course_id 
        LEFT JOIN inscriptions i ON c.id = i.course_id
        WHERE a.arbitre_id = $arbitre_id 
        GROUP BY c.id
        ORDER BY c.date_course DESC";

$result = mysqli_query($conn, $sql);
$historique = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique d'Arbitrage - Sprint Meet</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        /* Table des courses */
        .course-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .course-table th, .course-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .course-table th {
            background-color: var(--primary-blue);
            color: var(--white);
        }
        .course-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .course-table tr:hover {
            background-color: #e0e7ff;
        }

        /* Boutons d’action */
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            color: var(--white);
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn i {
            margin-right: 5px;
        }
        .btn-noter {
            background-color: #27ae60; /* Vert */
        }
        .btn-noter:hover {
            background-color: #219653;
        }
        .btn-consulter {
            background-color: #1f618d; /* Bleu foncé */
        }
        .btn-consulter:hover {
            background-color: #154360;
        }
        .btn:hover {
            transform: translateY(-3px);
        }

        /* Lien Retour */
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
    </style>
</head>
<body>
    <header>
        <h1>Historique des Courses Arbitrées</h1>
    </header>

    <table class="course-table">
        <thead>
            <tr>
                <th>Course</th>
                <th>Date</th>
                <th>Type</th>
                <th>Participants</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historique as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['nom']); ?></td>
                    <td><?php echo $course['date_course']; ?></td>
                    <td><?php echo htmlspecialchars($course['course_type']); ?></td>
                    <td><?php echo $course['nb_participants']; ?></td>
                    <td class="action-buttons">
                        <a href="noter_performances.php?course_id=<?php echo $course['id']; ?>" class="btn btn-noter"><i class="fas fa-pen"></i> Noter</a>
                        <a href="consulter_resultats.php?course_id=<?php echo $course['id']; ?>" class="btn btn-consulter"><i class="fas fa-search"></i> Résultats</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="dashboard_arbitre.php" class="retour">Retour au tableau de bord</a>
</body>
</html>