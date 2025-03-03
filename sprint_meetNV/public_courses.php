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
    require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

    // Récupérer la liste des courses
    $sql = "SELECT * FROM courses ORDER BY date_course DESC";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<ul>";
        while ($course = mysqli_fetch_assoc($result)) {
            echo "<li>" . htmlspecialchars($course['nom']) . " - " . htmlspecialchars($course['date_course']);
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'athlete') {
                echo " <a href='scripts/register_to_course.php?course_id=" . $course['id'] . "'>S'inscrire</a>";
            }
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
  ?>
</body>
</html>