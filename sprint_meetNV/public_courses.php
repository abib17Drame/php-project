<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Courses Publiques - Sprint Meet</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Liste des Courses</h1>
  <?php
    session_start();
    require_once 'includes/db_connect.php';
    try {
      $sql = "SELECT * FROM courses ORDER BY date_course DESC";
      $stmt = $pdo->query($sql);
      echo "<ul>";
      while ($course = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>" . htmlspecialchars($course['nom']) . " - " . htmlspecialchars($course['date_course']);
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'athlete') {
          echo " <a href='scripts/register_to_course.php?course_id=" . $course['id'] . "'>S'inscrire</a>";
        }
        echo "</li>";
      }
      echo "</ul>";
    } catch (PDOException $e) {
      echo "Erreur : " . $e->getMessage();
    }
  ?>
</body>
</html>
