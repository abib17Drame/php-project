<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Courses - Sprint Meet</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Liste des Courses</h1>
  <a href="scripts/add_course.php">Ajouter une Course</a>
  <?php
    require_once 'includes/db_connect.php';
    try {
      $sql = "SELECT * FROM courses ORDER BY date_course DESC";
      $stmt = $pdo->query($sql);
      echo "<table border='1'>";
      echo "<tr><th>ID</th><th>Nom</th><th>Type</th><th>Phase</th><th>Date</th></tr>";
      while($course = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($course['id']) . "</td>";
        echo "<td>" . htmlspecialchars($course['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($course['course_type']) . "</td>";
        echo "<td>" . htmlspecialchars($course['round_type']) . "</td>";
        echo "<td>" . htmlspecialchars($course['date_course']) . "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } catch(PDOException $e) {
      echo "Erreur : " . $e->getMessage();
    }
  ?>
</body>
</html>
