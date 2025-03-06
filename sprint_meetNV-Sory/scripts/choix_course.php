<?php
session_start();
require_once '../includes/db_connect.php';

// Vérifier si l'utilisateur est connecté et est un athlète
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: ../login.html");
    exit;
}

//  l 'inscription à une course
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $user_id = $_SESSION['user_id'];

    // Vérifier si la course est ouverte
    $tr_course = "SELECT statut_inscription FROM courses WHERE id = $course_id AND statut_inscription = 'ouvert'";
    $result_course = mysqli_query($conn, $tr_course);

    if (mysqli_num_rows($result_course) == 0) {
        header("Location: choix_course.php?error=course_fermee");
        exit;
    }

    // Vérifier si l'athlète est déjà inscrit
    $tr_inscription = "SELECT id FROM inscriptions WHERE user_id = $user_id AND course_id = $course_id";
    $result_inscription = mysqli_query($conn, $tr_inscription);

    if (mysqli_num_rows($result_inscription) > 0) {
        header("Location: choix_course.php?error=deja_inscrit");
        exit;
    }

    // Inscrire l'athlète à la course
    $insert_sql = "INSERT INTO inscriptions (user_id, course_id) VALUES ($user_id, $course_id)";
    if (mysqli_query($conn, $insert_sql)) {
        header("Location: mescourses.php?success=inscription_reussie");
    } else {
        header("Location: choix_course.php?error=erreur_inscription");
    }
    exit;
}

$sql = "SELECT id, nom, course_type, round_type, date_course, statut_inscription 
        FROM courses 
        WHERE statut_inscription = 'ouvert'
        ORDER BY date_course ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription aux Courses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f7fa;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        .courses-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .course-item {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .course-item:hover {
            transform: translateY(-5px);
        }

        .course-item h3 {
            color: #34495e;
            margin-top: 0;
        }

        .course-item p {
            color: #7f8c8d;
            margin: 10px 0;
        }

        .btn-inscription {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            width: 100%;
            text-align: center;
            box-sizing: border-box;
            transition: background 0.3s;
        }

        .btn-inscription:hover {
            background: #2980b9;
        }

        .statut-ferme {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }

        .retour-btn {
            display: inline-block;
            background: #2c3e50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }

        .error {
            background: #ffebee;
            color: #c62828;
        }

        .success {
            background: #e8f5e9;
            color: #2e7d32;
        }
    </style>
</head>
<body>
    <h2>Courses disponibles</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="message error">
            <?php
            if ($_GET['error'] == 'course_fermee') {
                echo "Cette course n'est plus ouverte aux inscriptions.";
            } elseif ($_GET['error'] == 'deja_inscrit') {
                echo "Vous êtes déjà inscrit à cette course.";
            } elseif ($_GET['error'] == 'erreur_inscription') {
                echo "Une erreur est survenue lors de l'inscription.";
            }
            ?>
        </div>
    <?php endif; ?>

    <div class="courses-list">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="course-item">
                    <h3><?php echo htmlspecialchars($row['nom']); ?></h3>
                    <p>Type: <?php echo htmlspecialchars($row['course_type']); ?></p>
                    <p>Tour: <?php echo htmlspecialchars($row['round_type']); ?></p>
                    <p>Date: <?php echo htmlspecialchars($row['date_course']); ?></p>
                    <?php if($row['statut_inscription'] === 'ouvert'): ?>
                        <a href="?course_id=<?php echo $row['id']; ?>" class="btn-inscription">S'inscrire</a>
                    <?php else: ?>
                        <span class="statut-ferme">Inscriptions fermées</span>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Aucune course disponible pour le moment.</p>
        <?php endif; ?>
    </div>

    <a href="../dashboard_athlete.php" class="retour-btn">Retour au tableau de bord</a>
</body>
</html>