<?php
session_start();
require_once '../includes/db_connect.php';

// Vérifier si l'utilisateur est connecté et est un athlète
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: ../login.html");
    exit;
}

// Inscription à une course
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription aux Courses - Sprint Meet</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            overflow-x: hidden;
            padding: 20px;
        }

        /* Header */
        header {
            display: flex;
            align-items: center;
            justify-content: center;
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

        /* Messages d’erreur ou de succès */
        .message {
            padding: 15px;
            margin: 20px auto;
            border-radius: 8px;
            max-width: 600px;
            font-size: 1rem;
        }
        .message.error {
            background: #ffebee;
            color: #c62828;
        }
        .message.success {
            background: #e8f5e9;
            color: #2e7d32;
        }

        /* Grille des courses */
        .courses-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .course-item {
            background: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            text-align: left;
        }
        .course-item:hover {
            transform: translateY(-5px);
        }
        .course-item h3 {
            color: var(--primary-blue);
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .course-item p {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin: 5px 0;
        }

        /* Boutons d’action */
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            color: var(--white);
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-align: center;
            display: block;
            width: 100%;
        }
        .btn i {
            margin-right: 5px;
        }
        .btn-inscription {
            background-color: var(--primary-blue);
            margin-top: 10px;
        }
        .btn-inscription:hover {
            background-color: #1f6690;
            transform: translateY(-3px);
        }
        .btn-closed {
            background-color: var(--secondary-red);
            margin-top: 10px;
        }
        .btn-closed:hover {
            background-color: #c0392b;
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

        /* Responsive Design */
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            h1 {
                font-size: 1.5rem;
            }
            .courses-list {
                grid-template-columns: 1fr;
                padding: 10px;
            }
            .course-item {
                padding: 15px;
            }
            .btn, .retour {
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Inscription aux Courses</h1>
    </header>

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
                    <?php if ($row['statut_inscription'] === 'ouvert'): ?>
                        <a href="?course_id=<?php echo $row['id']; ?>" class="btn btn-inscription"><i class="fas fa-plus"></i> S'inscrire</a>
                    <?php else: ?>
                        <span class="btn btn-closed"><i class="fas fa-lock"></i> Inscriptions fermées</span>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; width: 100%; padding: 20px;">Aucune course disponible pour le moment.</p>
        <?php endif; ?>
    </div>

    <a href="dashboard_athlete.php" class="retour"><i class="fas fa-arrow-left"></i> Retour au tableau de bord</a>
</body>
</html>