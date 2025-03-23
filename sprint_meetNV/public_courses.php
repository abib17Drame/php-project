<?php
require_once 'includes/db_connect.php';

// Récupération des courses
$sql = "SELECT id, nom, course_type, date_course, statut_inscription 
        FROM courses 
        ORDER BY date_course DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Courses disponibles - Sprint Meet</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Variables CSS pour les couleurs */
        :root {
            --primary-blue: #2980b9; /* Bleu élégant */
            --secondary-red: #e74c3c; /* Rouge vibrant */
            --white: #fff;
            --black: #000;
            --light-gray: #f5f5f5;
            --medium-gray: #666;
        }

        /* Réinitialisation et styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--light-gray);
            color: var(--black);
            padding: 20px;
            min-height: 100vh;
        }

        /* Titre principal */
        h1 {
            font-size: 2.5rem;
            background: linear-gradient(90deg, var(--primary-blue), var(--secondary-red));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        }

        /* Container Grid */
        .d {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Carte de course */
        .carte_cou {
            background: var(--white);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .carte_cou:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        /* Titre de la course */
        .titre_course {
            color: var(--primary-blue);
            font-size: 1.4em;
            font-weight: 700;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        /* Informations sur la course */
        .course-info {
            color: var(--medium-gray);
            margin-bottom: 15px;
            font-size: 0.95em;
            line-height: 1.5;
        }
        .course-info p {
            margin: 5px 0;
        }

        /* Bouton d'inscription */
        .inscription-btn {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(90deg, var(--primary-blue), var(--secondary-red));
            color: var(--white);
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            font-weight: 700;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .inscription-btn:hover {
            background: linear-gradient(90deg, var(--secondary-red), var(--primary-blue));
            transform: translateY(-3px);
        }

        /* Bouton pour inscriptions fermées */
        .statut-ferme {
            background: var(--medium-gray);
            pointer-events: none;
            opacity: 0.7;
            transform: none; /* Pas d'effet au survol */
        }
    </style>
</head>
<body>
    <h1>Courses Disponibles</h1>

    <div class="d">
        <?php while($course = mysqli_fetch_assoc($result)): ?>
            <div class="carte_cou">
                <div class="titre_course">
                    <?php echo htmlspecialchars($course['nom']); ?>
                </div>
                <div class="course-info">
                    <p>Type: <?php echo htmlspecialchars($course['course_type']); ?></p>
                    <p>Date: <?php echo htmlspecialchars($course['date_course']); ?></p>
                    <p>Statut: <?php echo htmlspecialchars($course['statut_inscription']); ?></p>
                </div>
                <?php if($course['statut_inscription'] == 'ouvert'): ?>
                    <a href="athlete/choix_course.php" class="inscription-btn">S'inscrire</a>
                <?php else: ?>
                    <a class="inscription-btn statut-ferme">Inscriptions fermées</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>