<?php
require_once '../includes/db_connect.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Assignations - Sprint Meet</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2980b9; /* Bleu élégant */
            --secondary-red: #e74c3c; /* Rouge vibrant */
            --white: #fff;
            --black: #000;
        }

        /* Styles généraux */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--white);
            color: var(--black);
            text-align: center;
            min-height: 100vh;
            padding: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        /* En-tête */
        header {
            background: linear-gradient(90deg, var(--primary-blue), var(--secondary-red));
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            color: var(--white);
        }
        h1 {
            font-size: 2rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }

        /* Conteneur flex */
        .container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .section {
            flex: 1;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            min-width: 300px;
        }
        .section h2 {
            color: var(--primary-blue);
            margin-bottom: 15px;
        }

        /* Tableau */
        .courses-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .courses-table th, .courses-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .courses-table th {
            background-color: var(--primary-blue);
            color: var(--white);
        }
        .courses-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .courses-table tr:hover {
            background-color: #e0e7ff;
        }

        /* Formulaire */
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        /* Boutons */
        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            color: var(--white);
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            display: inline-block;
        }
        .btn-assign {
            background: var(--primary-blue); /* Bleu principal */
            border: none;
        }
        .btn-assign:hover {
            background: #1f6690; /* Bleu plus foncé au survol */
            transform: translateY(-3px);
        }
        .btn-remove {
            background: var(--secondary-red);
        }
        .btn-remove:hover {
            background: #c0392b;
            transform: translateY(-3px);
        }
        .btn-retour {
            background: var(--primary-blue);
            padding: 12px 25px;
            margin-top: 20px;
        }
        .btn-retour:hover {
            background: var(--secondary-red);
            transform: translateY(-3px);
        }

        /* Design responsive */
        @media (max-width: 600px) {
            .container {
                flex-direction: column;
            }
            .section {
                min-width: 100%;
            }
            .courses-table th, .courses-table td {
                padding: 8px;
                font-size: 0.9rem;
            }
            h1 {
                font-size: 1.5rem;
            }
            .btn {
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Gestion des Assignations - <?php echo htmlspecialchars($arbitre['prenom'] . ' ' . $arbitre['nom']); ?></h1>
    </header>

    <div class="container">
        <div class="section">
            <h2>Assigner une nouvelle course</h2>
            <form method="POST">
                <select name="course_id" required>
                    <option value="">Sélectionner une course</option>
                    <?php foreach ($courses_disponibles as $course): ?>
                        <option value="<?php echo $course['id']; ?>">
                            <?php echo htmlspecialchars($course['nom'] . ' (' . $course['date_course'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="assigner" class="btn btn-assign">Assigner</button>
            </form>
        </div>

        <div class="section">
            <h2>Courses Assignées</h2>
            <table class="courses-table">
                <tr>
                    <th>Course</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($courses_assignees as $course): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($course['nom']); ?></td>
                        <td><?php echo htmlspecialchars($course['date_course']); ?></td>
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

    <a href="arbitres.php" class="btn btn-retour">Retour à la liste</a>
</body>
</html>