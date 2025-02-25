<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des Athlètes - Sprint Meet</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>Liste des Athlètes</h1>
  <?php
    require_once 'includes/db_connect.php';
    try {
      $sql = "SELECT * FROM users WHERE role = 'athlete'";
      $stmt = $pdo->query($sql);
      echo "<table border='1'>";
      echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th></tr>";
      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($row['prenom']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } catch(PDOException $e) {
      echo "Erreur : " . $e->getMessage();
    }
  ?>
</body>
</html>
