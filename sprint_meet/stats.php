<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Statistiques - Sprint Meet</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Statistiques</h1>
  <?php
    require_once 'includes/db_connect.php';
    try {
      $coursesCount = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
      $athletesCount = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'athlete'")->fetchColumn();
      $performancesCount = $pdo->query("SELECT COUNT(*) FROM performances")->fetchColumn();
      
      echo "<p>Nombre de courses : " . htmlspecialchars($coursesCount) . "</p>";
      echo "<p>Nombre d'athlètes : " . htmlspecialchars($athletesCount) . "</p>";
      echo "<p>Nombre de performances enregistrées : " . htmlspecialchars($performancesCount) . "</p>";
    } catch(PDOException $e) {
      echo "Erreur : " . $e->getMessage();
    }
  ?>
</body>
</html>
