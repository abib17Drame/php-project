<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Résultats - Sprint Meet</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Résultats des Courses</h1>
  <?php
    require_once 'includes/db_connect.php';
    try {
      $sql = "SELECT p.id, u.nom, u.prenom, c.nom AS course, p.temps, p.statut 
              FROM performances p 
              JOIN inscriptions i ON p.inscription_id = i.id 
              JOIN users u ON i.user_id = u.id 
              JOIN courses c ON i.course_id = c.id
              ORDER BY c.date_course DESC";
      $stmt = $pdo->query($sql);
      echo "<table border='1'>";
      echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Course</th><th>Temps</th><th>Statut</th></tr>";
      while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($result['id']) . "</td>";
        echo "<td>" . htmlspecialchars($result['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($result['prenom']) . "</td>";
        echo "<td>" . htmlspecialchars($result['course']) . "</td>";
        echo "<td>" . htmlspecialchars($result['temps']) . "</td>";
        echo "<td>" . htmlspecialchars($result['statut']) . "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } catch(PDOException $e) {
      echo "Erreur : " . $e->getMessage();
    }
  ?>
</body>
</html>
