<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header("Location: login.html");
    exit;
}

try {
    $stmt = $pdo->query("SELECT * FROM courses ORDER BY date_course ASC");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Arbitre</title>
    <style>
        /* Style général */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
    color: #333;
    margin: 0;
    padding: 0;
    text-align: center;
}

/* Navigation */
nav {
    background: linear-gradient(135deg, #2c3e50, #34495e);
    padding: 15px 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
}

nav ul li {
    margin: 0 20px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    padding: 10px 20px;
    transition: background-color 0.3s, transform 0.3s;
    border-radius: 25px;
}

nav ul li a:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transform: translateY(-3px);
}

/* Contenu */
h1 {
    color: #2c3e50;
    margin-top: 20px;
}

/* Tableau */
table {
    width: 80%;
    margin: 30px auto;
    border-collapse: collapse;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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

tr:hover {
    background-color: #f1f1f1;
}

/* Liens d'action */
a {
    text-decoration: none;
    color: #2980b9;
    font-weight: bold;
}

a:hover {
    color: #1c6ea4;
}

    </style>
</head>
<body>
    <h1>Tableau de Bord Arbitre</h1>
    <nav>
        <ul>
            <li><a href="dashboard_arbitre.php">Accueil</a></li>
            <li><a href="scripts/logout.php">Se déconnecter</a></li>
        </ul>
    </nav>

    <h2>Liste des courses</h2>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php foreach ($courses as $course): ?>
        <tr>
            <td><?php echo htmlspecialchars($course['nom']); ?></td>
            <td><?php echo htmlspecialchars($course['course_type']); ?></td>
            <td><?php echo htmlspecialchars($course['date_course']); ?></td>
            <td>
                <a href="results.php?course_id=<?php echo htmlspecialchars($course['id']); ?>">Ajouter Résultats</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
