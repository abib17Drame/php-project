<?php
session_start();
require_once 'includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header("Location: login.html");
    exit;
}

// Vérifier si l'ID de la course est spécifié
$course_id = $_GET['course_id'] ?? null;
if (!$course_id) {
    die("Erreur : Course non spécifiée.");
}

// Récupérer les informations de la course
try {
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
</head>
<body>

    <h1>Ajouter Résultats pour : <?php echo htmlspecialchars($course['nom']); ?></h1>

    <p><strong>Type de course :</strong> <?php echo htmlspecialchars($course['course_type']); ?></p>
    <p><strong>Date :</strong> <?php echo htmlspecialchars($course['date_course']); ?></p>

    <h2>Liste des athlètes</h2>

    <form action="enregistrer_resultats.php" method="POST">
        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
        <table border="1">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Sexe</th>
                <th>Âge</th>
                <th>Pays</th>
                <th>Temps (en secondes)</th>
                <th>Statut</th>
            </tr>
            <?php if (empty($athletes)): ?>
                <tr><td colspan="7">Aucun athlète inscrit.</td></tr>
            <?php else: ?>
                <?php foreach ($athletes as $athlete): ?>
                <tr>
                    <td><?php echo htmlspecialchars($athlete['nom']); ?></td>
                    <td><?php echo htmlspecialchars($athlete['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($athlete['sexe']); ?></td>
                    <td><?php echo htmlspecialchars($athlete['age']); ?></td>
                    <td><?php echo htmlspecialchars($athlete['pays']); ?></td>
                    <td>
                        <input type="number" name="temps[<?php echo $athlete['inscription_id']; ?>]" step="0.01" min="0">
                    </td>
                    <td>
                        <select name="statut[<?php echo $athlete['inscription_id']; ?>]">
                            <option value="OK">OK</option>
                            <option value="DNS">DNS (Did Not Start)</option>
                            <option value="DNF">DNF (Did Not Finish)</option>
                            <option value="DSQ">DSQ (Disqualified)</option>
                        </select>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

        <?php if (!empty($athletes)): ?>
            <button type="submit">Enregistrer les résultats</button>
        <?php endif; ?>
    </form>

    <p><a href="dashboard_arbitre.php">Retour au Dashboard</a></p>

</body>
</html>
