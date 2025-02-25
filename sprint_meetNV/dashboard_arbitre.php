<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header("Location: login.html");
    exit;
}

try {
    // Récupérer uniquement les courses assignées à cet arbitre
    $stmt = $pdo->prepare("
        SELECT c.* 
        FROM courses c 
        INNER JOIN arbitrage a ON c.id = a.course_id 
        WHERE a.arbitre_id = ? 
        ORDER BY c.date_course ASC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Arbitre - Sprint Meet</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* Quelques styles supplémentaires pour le dashboard */
    .container {
      max-width: 1100px;
      margin: 30px auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      text-align: center;
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
      transition: background 0.3s;
    }
    nav ul li a:hover {
      background: #34495e;
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
    tr:hover {
      background-color: #f1f1f1;
    }
    .btn {
      padding: 8px 16px;
      background-color: #3498db;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background 0.3s;
    }
    .btn:hover {
      background-color: #2980b9;
    }
    /* Ajouter des styles pour les nouveaux boutons */
    .btn-noter {
        background-color: #27ae60;
    }
    .btn-consulter {
        background-color: #9b59b6;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Tableau de Bord Arbitre</h1>
        <nav>
            <ul>
                <li><a href="dashboard_arbitre.php">Accueil</a></li>
                <li><a href="historique_arbitrage.php">Historique Courses</a></li>
                <li><a href="scripts/logout.php">Se Déconnecter</a></li>
            </ul>
        </nav>
    <h2>Mes Courses Assignées</h2>
    <?php if (empty($courses)): ?>
      <p>Aucune course ne vous a été assignée.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($courses as $course): ?>
            <tr>
              <td><?php echo htmlspecialchars($course['nom']); ?></td>
              <td><?php echo htmlspecialchars($course['course_type']); ?></td>
              <td><?php echo htmlspecialchars($course['date_course']); ?></td>
              <td>
                <a class="btn btn-noter" href="noter_performances.php?course_id=<?= $course['id'] ?>">Noter</a>
                <a class="btn btn-consulter" href="consulter_resultats.php?course_id=<?= $course['id'] ?>">Résultats</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

</body>
</html>
