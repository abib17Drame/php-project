<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header("Location: login.html");
    exit;
}

$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
if ($course_id <= 0) {
    die("Erreur : Course non spécifiée.");
}

try {
    // Récupérer la course
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = :course_id");
    $stmt->execute([':course_id' => $course_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$course) {
        die("Erreur : Course introuvable.");
    }

    // Récupérer les athlètes inscrits à cette course
    $stmt = $pdo->prepare("
        SELECT i.id AS inscription_id, u.nom, u.prenom, u.sexe, u.age, u.pays
        FROM inscriptions i
        JOIN users u ON i.user_id = u.id
        WHERE i.course_id = :course_id
    ");
    $stmt->execute([':course_id' => $course_id]);
    $athletes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Résultats - Sprint Meet</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Quelques styles spécifiques à cette page */
        .container {
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #2c3e50;
            color: #fff;
        }
        .btn {
            padding: 8px 16px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

  <div class="container">
    <h1>Ajouter Résultats pour : <?php echo htmlspecialchars($course['nom']); ?></h1>
    <p><strong>Type :</strong> <?php echo htmlspecialchars($course['course_type']); ?></p>
    <p><strong>Date :</strong> <?php echo htmlspecialchars($course['date_course']); ?></p>

    <form action="enregistrer_resultats.php" method="POST">
        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Temps (s)</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($athletes)): ?>
                    <tr>
                        <td colspan="4">Aucun athlète inscrit pour cette course.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($athletes as $athlete): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($athlete['nom']); ?></td>
                        <td><?php echo htmlspecialchars($athlete['prenom']); ?></td>
                        <td>
                            <input type="number" name="temps[<?php echo $athlete['inscription_id']; ?>]" step="0.01" min="0" required>
                        </td>
                        <td>
                            <select name="statut[<?php echo $athlete['inscription_id']; ?>]" required>
                                <option value="OK">OK</option>
                                <option value="DNS">DNS</option>
                                <option value="DNF">DNF</option>
                                <option value="DSQ">DSQ</option>
                            </select>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <button type="submit" class="btn">Enregistrer les résultats</button>
    </form>
    <p><a class="btn" href="dashboard_arbitre.php">Retour au Dashboard</a></p>
  </div>

</body>
</html>
