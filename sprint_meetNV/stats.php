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
    require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

    // Récupérer le nombre de courses
    $sql_courses = "SELECT COUNT(*) FROM courses";
    $result_courses = mysqli_query($conn, $sql_courses);
    $coursesCount = mysqli_fetch_row($result_courses)[0];

    // Récupérer le nombre d'athlètes
    $sql_athletes = "SELECT COUNT(*) FROM users WHERE role = 'athlete'";
    $result_athletes = mysqli_query($conn, $sql_athletes);
    $athletesCount = mysqli_fetch_row($result_athletes)[0];

    // Récupérer le nombre de performances enregistrées
    $sql_performances = "SELECT COUNT(*) FROM performances";
    $result_performances = mysqli_query($conn, $sql_performances);
    $performancesCount = mysqli_fetch_row($result_performances)[0];

    // Afficher les statistiques
    echo "<p>Nombre de courses : " . htmlspecialchars($coursesCount) . "</p>";
    echo "<p>Nombre d'athlètes : " . htmlspecialchars($athletesCount) . "</p>";
    echo "<p>Nombre de performances enregistrées : " . htmlspecialchars($performancesCount) . "</p>";
  ?>
</body>
</html>