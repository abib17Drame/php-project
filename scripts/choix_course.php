<?php
session_start();
require_once '../includes/db_connect.php';

// Vérifier que l'utilisateur est connecté et qu'il est un athlète
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: ../login.html");
    exit;
}

// Récupérer les courses disponibles (par exemple, celles dont la date est supérieure ou égale à aujourd'hui)
try {
    $sql = "SELECT * FROM courses WHERE date_course >= CURDATE() ORDER BY date_course ASC";
    $stmt = $pdo->query($sql);
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de récupération des courses : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Choisir une Course</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <h1>Choisissez la course à laquelle vous souhaitez vous inscrire</h1>
  <?php if (empty($courses)): ?>
      <p>Aucune course disponible pour le moment.</p>
  <?php else: ?>
      <form action="register_to_course.php" method="GET">
          <label for="course_id">Liste des courses disponibles :</label>
          <select name="course_id" id="course_id" required>
              <?php foreach ($courses as $course): ?>
                  <option value="<?php echo htmlspecialchars($course['id']); ?>">
                      <?php echo htmlspecialchars($course['nom']) . " - " . htmlspecialchars($course['date_course']); ?>
                  </option>
              <?php endforeach; ?>
          </select>
          <button type="submit">S'inscrire</button>
      </form>
  <?php endif; ?>
</body>
</html>
