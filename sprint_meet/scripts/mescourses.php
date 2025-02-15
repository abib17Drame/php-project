<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: ../login.html");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT i.course_id, c.nom, c.date_course, c.course_type, c.round_type 
                           FROM inscriptions i 
                           JOIN courses c ON i.course_id = c.id
                           WHERE i.user_id = :user_id
                           ORDER BY c.date_course ASC");
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

$message = $_GET['message'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes Inscriptions - Sprint Meet</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <h1>Mes Inscriptions</h1>
  <?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
  <?php endif; ?>
  <?php if (empty($registrations)): ?>
      <p>Vous n'êtes inscrit à aucune course pour le moment.</p>
  <?php else: ?>
      <table border="1">
          <tr>
              <th>Nom de la course</th>
              <th>Date</th>
              <th>Type</th>
              <th>Phase</th>
              <th>Action</th>
          </tr>
          <?php foreach ($registrations as $reg): ?>
          <tr>
              <td><?php echo htmlspecialchars($reg['nom']); ?></td>
              <td><?php echo htmlspecialchars($reg['date_course']); ?></td>
              <td><?php echo htmlspecialchars($reg['course_type']); ?></td>
              <td><?php echo htmlspecialchars($reg['round_type']); ?></td>
              <td>
                 <a href="ann_ins.php?course_id=<?php echo htmlspecialchars($reg['course_id']); ?>">Annuler inscription</a>
              </td>
          </tr>
          <?php endforeach; ?>
      </table>
  <?php endif; ?>
  <p><a href="../dashboard_athlete.html">Retour au Dashboard</a></p>
</body>
</html>
