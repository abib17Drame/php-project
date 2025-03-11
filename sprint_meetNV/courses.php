<?php
require_once 'includes/db_connect.php'; // Connexion à la base de données

// Récupération des courses
$sql = "SELECT * FROM courses ORDER BY date_course DESC";
$result = mysqli_query($conn, $sql);
$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Courses - Sprint Meet</title>
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

        /* Bouton "Ajouter une course" */
        .add-course {
            margin: 20px 0;
        }
        .btn-add {
            padding: 12px 25px; /* Même padding que .retour */
            border-radius: 8px; /* Même rayon que .retour */
            cursor: pointer;
            color: var(--white);
            text-decoration: none;
            background-color: var(--primary-blue); /* Même couleur que .retour */
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-align: center;
            display: inline-block;
        }
        .btn-add i {
            margin-right: 5px;
        }
        .btn-add:hover {
            background-color: var(--secondary-red); /* Même survol que .retour */
            transform: translateY(-3px);
        }

        /* Table des courses */
        .course-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .course-table th, .course-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .course-table th {
            background-color: var(--primary-blue);
            color: var(--white);
        }
        .course-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .course-table tr:hover {
            background-color: #e0e7ff;
        }

        /* Boutons d’action */
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 8px 15px;
            min-width: 120px;
            border-radius: 4px;
            cursor: pointer;
            color: var(--white);
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-align: center;
        }
        .btn i {
            margin-right: 5px;
        }
        .btn-edit {
            background-color: #3498db; /* Bleu clair pour modifier */
        }
        .btn-edit:hover {
            background-color: #2980b9; /* Bleu principal */
        }
        .btn-delete {
            background-color: var(--secondary-red); /* Rouge pour supprimer */
        }
        .btn-delete:hover {
            background-color: #c0392b; /* Rouge foncé */
        }
        .btn-view {
            background-color: #1f618d; /* Bleu foncé pour voir */
        }
        .btn-view:hover {
            background-color: #154360; /* Plus foncé */
        }
        .btn:hover {
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
        <h1>Gestion des Courses</h1>
    </header>

    <div class="add-course">
        <a href="add_course.php" class="btn-add"><i class="fas fa-plus"></i> Ajouter une course</a>
    </div>

    <table class="course-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Date</th>
                <th>Statut Inscriptions</th>
                <th>Nombre d'inscrits</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): 
                $sql_count = "SELECT COUNT(*) FROM inscriptions WHERE course_id = " . $course['id'];
                $count_result = mysqli_query($conn, $sql_count);
                $count = mysqli_fetch_row($count_result)[0];
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['nom']); ?></td>
                    <td><?php echo htmlspecialchars($course['date_course']); ?></td>
                    <td><?php echo htmlspecialchars($course['statut_inscription']); ?></td>
                    <td><?php echo $count; ?></td>
                    <td class="action-buttons">
                        <a href="modifier_course.php?id=<?php echo $course['id']; ?>" class="btn btn-edit"><i class="fas fa-edit"></i> Modifier</a>
                        <a href="supprimer_course.php?id=<?php echo $course['id']; ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette course ?')"><i class="fas fa-trash"></i> Supprimer</a>
                        <a href="inscrits_course.php?id=<?php echo $course['id']; ?>" class="btn btn-view"><i class="fas fa-search"></i> Voir inscrits</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="dashboard_admin.php" class="retour">Retour au tableau de bord</a>
</body>
</html>