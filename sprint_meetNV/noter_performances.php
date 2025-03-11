<?php
session_start();
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

// Vérifie si l'utilisateur est connecté et est un arbitre
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'arbitre') {
    header('Location: login.html');
    exit;
}

// Vérifie si l'ID de la course est présent dans l'URL
if (!isset($_GET['course_id'])) {
    header('Location: dashboard_arbitre.php');
    exit;
}
$course_id = $_GET['course_id'];

// Récupère les informations de la course
$sql = "SELECT * FROM courses WHERE id = $course_id";
$result = mysqli_query($conn, $sql);
$course = mysqli_fetch_assoc($result);

// Récupère les athlètes inscrits à la course
$sql = "SELECT u.*, i.temps_realise 
        FROM users u 
        INNER JOIN inscriptions i ON u.id = i.user_id 
        WHERE i.course_id = $course_id AND u.role = 'athlete'
        ORDER BY i.temps_realise";
$result_athletes = mysqli_query($conn, $sql);
$athletes = mysqli_fetch_all($result_athletes, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noter les Performances - Sprint Meet</title>
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

        /* Formulaire de performances */
        .performance-form {
            max-width: 800px;
            margin: 20px auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .athlete-row {
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: var(--white);
        }
        .form-group {
            margin: 10px 0;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .btn-save {
            background: var(--primary-blue); /* Bleu principal */
            color: var(--white);
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-save:hover {
            background: #1f6690; /* Bleu plus foncé au survol */
            transform: translateY(-3px);
        }

        /* Lien Retour */
        .retour {
            display: inline-block;
            padding: 12px 25px;
            background: var(--primary-blue);
            color: var(--white);
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .retour:hover {
            background: var(--secondary-red);
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <header>
        <h1>Noter les Performances - <?php echo htmlspecialchars($course['nom']); ?></h1>
    </header>

    <form class="performance-form" method="POST" action="sauvegarder_performances.php">
        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
        <?php foreach ($athletes as $athlete): ?>
            <div class="athlete-row">
                <h3><?php echo htmlspecialchars($athlete['prenom'] . ' ' . $athlete['nom']); ?></h3>
                <div class="form-group">
                    <label>Temps réalisé (format: MM:SS.ms) :</label>
                    <input type="text" name="temps[<?php echo $athlete['id']; ?>]" 
                           value="<?php echo $athlete['temps_realise']; ?>" 
                           pattern="[0-9]{2}:[0-9]{2}.[0-9]{2}">
                </div>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn-save">Sauvegarder les résultats</button>
    </form>

    <a href="dashboard_arbitre.php" class="retour">Retour au tableau de bord</a>
</body>
</html>