<?php
session_start();
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

// Vérifie si l'utilisateur est connecté et est un arbitre
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header('Location: login.html');
    exit;
}

// Récupérer l'historique des courses arbitrées
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
    <title>Historique d'Arbitrage</title>
    <style>
        .container {
            max-width: 1100px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        
        th {
            background-color: #2c3e50;
            color: #fff;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .btn {
            padding: 8px 16px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin: 0 5px;
        }
        
        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            padding: 0;
            background: #2c3e50;
        }
        
        nav ul li {
            margin: 0 15px;
        }
        
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            padding: 10px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Historique des Courses Arbitrées</h1>
        
        <nav>
            <ul>
                <li><a href="dashboard_arbitre.php">Accueil</a></li>
                <li><a href="scripts/logout.php">Se Déconnecter</a></li>
            </ul>
        </nav>

        <table>
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
                        <td>
                            <a class="btn btn-noter" href="noter_performances.php?course_id=<?php echo $course['id']; ?>">Noter</a>
                            <a class="btn btn-consulter" href="consulter_resultats.php?course_id=<?php echo $course['id']; ?>">Résultats</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>