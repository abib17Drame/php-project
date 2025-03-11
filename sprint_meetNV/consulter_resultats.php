<?php
session_start();
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

// Vérifie si l'utilisateur est connecté et est un arbitre
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header('Location: login.html');
    exit; 
}

// Vérifie si l'ID de la course est présent dans l'URL
if (!isset($_GET['course_id'])) {
    header('Location: dashboard_arbitre.php');
    exit;
}
$course_id = $_GET['course_id'];

// Récupérer les informations de la course
$sql = "SELECT * FROM courses WHERE id = '$course_id'";
$result = mysqli_query($conn, $sql);
$course = mysqli_fetch_assoc($result);

if (!$course) {
    header('Location: dashboard_arbitre.php');
    exit;
}

// Récupérer les résultats
$sql = "SELECT u.nom, u.prenom, i.temps_realise 
        FROM users u 
        INNER JOIN inscriptions i ON u.id = i.user_id 
        WHERE i.course_id = '$course_id' 
        ORDER BY i.temps_realise";
$result = mysqli_query($conn, $sql);
$resultats = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la Course - Sprint Meet</title>
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

        /* Tableau des résultats */
        .resultats-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .resultats-table th, .resultats-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .resultats-table th {
            background-color: var(--primary-blue);
            color: var(--white);
        }
        .resultats-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .resultats-table tr:hover {
            background-color: #e0e7ff;
        }

        /* Boutons d’action */
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            color: var(--white);
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            display: inline-block;
            margin: 10px;
        }
        .btn i {
            margin-right: 5px;
        }
        .btn-modifier {
            background-color: #3498db; /* Bleu clair */
        }
        .btn-modifier:hover {
            background-color: #2980b9; /* Bleu principal */
            transform: translateY(-3px);
        }
        .retour {
            background-color: var(--primary-blue);
        }
        .retour:hover {
            background-color: var(--secondary-red);
            transform: translateY(-3px);
        }

        /* Design responsive */
        @media (max-width: 600px) {
            .resultats-table th, .resultats-table td {
                padding: 8px;
                font-size: 0.9rem;
            }
            .btn {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Résultats : <?php echo htmlspecialchars($course['nom']); ?></h1>
    </header>

    <table class="resultats-table">
        <tr>
            <th>Position</th>
            <th>Athlète</th>
            <th>Temps</th>
        </tr>
        <?php
        $position = 1;
        foreach ($resultats as $resultat): 
        ?>
            <tr>
                <td><?php echo $position++; ?></td>
                <td><?php echo htmlspecialchars($resultat['prenom'] . ' ' . $resultat['nom']); ?></td>
                <td><?php echo $resultat['temps_realise'] ?: 'Non enregistré'; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="noter_performances.php?course_id=<?php echo $course_id; ?>" class="btn btn-modifier"><i class="fas fa-edit"></i> Modifier les résultats</a>
    <a href="dashboard_arbitre.php" class="btn retour"><i class="fas fa-arrow-left"></i> Retour au tableau de bord</a>
</body>
</html>