<?php
require_once 'includes/db_connect.php';

$arbitre_id = $_GET['id'];

// Récupérer les infos de l'arbitre
$sql = "SELECT nom, prenom FROM users WHERE id = ? AND role = 'arbitre'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$arbitre_id]);
$arbitre = $stmt->fetch();

// Récupérer les courses assignées
$sql = "SELECT c.* FROM courses c 
        INNER JOIN arbitrage a ON c.id = a.course_id 
        WHERE a.arbitre_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$arbitre_id]);
$courses_assignees = $stmt->fetchAll();

// Récupérer les courses disponibles
$sql = "SELECT * FROM courses WHERE id NOT IN (
    SELECT course_id FROM arbitrage WHERE arbitre_id = ?
)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$arbitre_id]);
$courses_disponibles = $stmt->fetchAll();

// Traiter l'assignation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assigner'])) {
    $course_id = $_POST['course_id'];
    $sql = "INSERT INTO arbitrage (arbitre_id, course_id) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$arbitre_id, $course_id]);
    header("Location: gerer_assignations.php?id=" . $arbitre_id);
    exit;
}

// Traiter le retrait
if (isset($_GET['retirer'])) {
    $course_id = $_GET['retirer'];
    $sql = "DELETE FROM arbitrage WHERE arbitre_id = ? AND course_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$arbitre_id, $course_id]);
    header("Location: gerer_assignations.php?id=" . $arbitre_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Assignations</title>
    <style>
        body { 
            font-family: Arial; 
            max-width: 1000px; 
            margin: 0 auto; 
            padding: 20px; 
        }
        .container {
            display: flex;
            gap: 20px;
        }
        .section {
            flex: 1;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0; 
        }
        th, td { 
            padding: 10px; 
            border: 1px solid #ddd; 
        }
        th { 
            background: #2c3e50; 
            color: white; 
        }
        .btn { 
            padding: 6px 12px; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px;
            display: inline-block;
            margin: 2px;
        }
        .btn-remove { background: #e74c3c; }
        .btn-assign { background: #27ae60; }
        select, button { 
            padding: 8px; 
            margin: 5px 0; 
        }
        select { width: 100%; }
    </style>
</head>
<body>
    <h1>Gestion des Assignations - <?= $arbitre['prenom'] . ' ' . $arbitre['nom'] ?></h1>

    <div class="container">
        <div class="section">
            <h2>Assigner une nouvelle course</h2>
            <form method="POST">
                <select name="course_id" required>
                    <option value="">Sélectionner une course</option>
                    <?php foreach($courses_disponibles as $course): ?>
                        <option value="<?= $course['id'] ?>">
                            <?= $course['nom'] ?> (<?= $course['date_course'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="assigner" class="btn btn-assign">Assigner</button>
            </form>
        </div>

        <div class="section">
            <h2>Courses Assignées</h2>
            <table>
                <tr>
                    <th>Course</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php foreach($courses_assignees as $course): ?>
                    <tr>
                        <td><?= $course['nom'] ?></td>
                        <td><?= $course['date_course'] ?></td>
                        <td>
                            <a href="?id=<?= $arbitre_id ?>&retirer=<?= $course['id'] ?>" 
                               class="btn btn-remove"
                               onclick="return confirm('Confirmer le retrait ?')">
                                Retirer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <a href="arbitres.php" class="btn">Retour à la liste</a>
</body>
</html>
