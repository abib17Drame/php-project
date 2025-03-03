<?php
session_start();
require_once '../includes/db_connect.php';

// Vérifie si l'utilisateur est connecté et est un athlète
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: ../login.html");
    exit;
}

// Récupère les inscriptions de l'utilisateur
$user_id = $_SESSION['user_id'];
$sql = "SELECT i.course_id, c.nom, c.date_course, c.course_type, c.round_type
        FROM inscriptions i
        JOIN courses c ON i.course_id = c.id
        WHERE i.user_id = '$user_id'
        ORDER BY c.date_course ASC";
$result = mysqli_query($conn, $sql);
$registrations = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Courses</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #333;
            padding: 10px;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        #mes-courses {
            background-color: white;
            padding: 20px;
            margin: 20px auto;
            max-width: 1000px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .statut {
            font-weight: bold;
        }

        .statut.terminee {
            color: red;
        }

        .statut.a-venir {
            color: green;
        }

        .details-btn {
            background-color: #333;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .details-btn:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="../dashboard_athlete.html">Tableau de bord</a></li>
            <li><a href="mes_informations.php">Mes informations</a></li>
            <li><a href="../results.php">Résultats</a></li>
            <li><a href="mes_stats.html">Statistiques</a></li>
            <li><a href="choix_course.php">S'inscrire à une course</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <section id="mes-courses">
        <h1>Mes Courses</h1>
        <table>
            <thead>
                <tr>
                    <th>Nom de la course</th>
                    <th>Type course</th>
                    <th>Date & Heure</th>
                    <th>Statut</th>
                    <th>Détails</th>
                    <th>Annuler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($registrations)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Vous n'êtes inscrit à aucune course pour le moment.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($registrations as $reg): 
                        $statut = (strtotime($reg['date_course']) < time()) ? 'Terminée' : 'À venir';
                        $statutClass = (strtotime($reg['date_course']) < time()) ? 'statut terminee' : 'statut a-venir';
                    ?>
                    <tr>
                        <td><?php echo $reg['nom']; ?></td>
                        <td><?php echo $reg['course_type']; ?></td>
                        <td><?php echo $reg['date_course']; ?></td>
                        <td class="<?php echo $statutClass; ?>"><?php echo $statut; ?></td>
                        <td><button class="details-btn" onclick="alert('Nom: <?php echo $reg['nom']; ?>\nDate: <?php echo $reg['date_course']; ?>\nStatut: <?php echo $statut; ?>')">Détails</button></td>
                        <td><a href="ann_ins.php?course_id=<?php echo $reg['course_id']; ?>">Annuler</a></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</body>
</html>