<?php
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

$arbitre_id = $_GET['id'];

// Récupérer les infos de l'arbitre
$sql = "SELECT nom, prenom FROM users WHERE id = $arbitre_id AND role = 'arbitre'";
$result = mysqli_query($conn, $sql);
$arbitre = mysqli_fetch_assoc($result);

// Récupérer les courses assignées
$sql = "SELECT c.* FROM courses c 
        INNER JOIN arbitrage a ON c.id = a.course_id 
        WHERE a.arbitre_id = $arbitre_id";
$result_assignees = mysqli_query($conn, $sql);
$courses_assignees = mysqli_fetch_all($result_assignees, MYSQLI_ASSOC);

// Récupérer les courses disponibles
$sql = "SELECT * FROM courses WHERE id NOT IN (
    SELECT course_id FROM arbitrage WHERE arbitre_id = $arbitre_id
)";
$result_disponibles = mysqli_query($conn, $sql);
$courses_disponibles = mysqli_fetch_all($result_disponibles, MYSQLI_ASSOC);

// Traiter l'assignation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assigner'])) {
    $course_id = $_POST['course_id'];
    $sql = "INSERT INTO arbitrage (arbitre_id, course_id) VALUES ($arbitre_id, $course_id)";
    mysqli_query($conn, $sql);
    header("Location: gerer_assignations.php?id=" . $arbitre_id);
    exit;
}

// Traiter le retrait
if (isset($_GET['retirer'])) {
    $course_id = $_GET['retirer'];
    $sql = "DELETE FROM arbitrage WHERE arbitre_id = $arbitre_id AND course_id = $course_id";
    mysqli_query($conn, $sql);
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
    <h1>Gestion des Assignations - <?php echo $arbitre['prenom'] . ' ' . $arbitre['nom']; ?></h1>

    <div class="container">
        <div class="section">
            <h2>Assigner une nouvelle course</h2>
            <form method="POST">
                <select name="course_id" required>
                    <option value="">Sélectionner une course</option>
                    <?php foreach ($courses_disponibles as $course): ?>
                        <option value="<?php echo $course['id']; ?>">
                            <?php echo $course['nom']; ?> (<?php echo $course['date_course']; ?>)
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
                <?php foreach ($courses_assignees as $course): ?>
                    <tr>
                        <td><?php echo $course['nom']; ?></td>
                        <td><?php echo $course['date_course']; ?></td>
                        <td>
                            <a href="?id=<?php echo $arbitre_id; ?>&retirer=<?php echo $course['id']; ?>" 
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