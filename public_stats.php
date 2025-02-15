<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Statistiques Publiques - Sprint Meet</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Statistiques des Courses</h1>
  <?php
    require_once 'includes/db_connect.php';
    try {
      $coursesCount = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
      $usersCount = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'athlete'")->fetchColumn();
      echo "<p>Nombre de courses : $coursesCount</p>";
      echo "<p>Nombre d'athlètes : $usersCount</p>";
    } catch(PDOException $e) {
      echo "Erreur : " . $e->getMessage();
    }
  ?>
</body>
</html>
