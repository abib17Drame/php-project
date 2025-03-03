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
    require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

    // Récupérer le nombre de courses
    $sql_courses = "SELECT COUNT(*) FROM courses";
    $result_courses = mysqli_query($conn, $sql_courses);
    $coursesCount = mysqli_fetch_row($result_courses)[0];

    // Récupérer le nombre d'athlètes
    $sql_users = "SELECT COUNT(*) FROM users WHERE role = 'athlete'";
    $result_users = mysqli_query($conn, $sql_users);
    $usersCount = mysqli_fetch_row($result_users)[0];

    // Afficher les statistiques
    echo "<p>Nombre de courses : $coursesCount</p>";
    echo "<p>Nombre d'athlètes : $usersCount</p>";
  ?>
</body>
</html>