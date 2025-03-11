<?php
require_once 'includes/db_connect.php';

$sql_types = "SELECT DISTINCT course_type FROM courses";
$typeres = mysqli_query($conn, $sql_types);
$typescourse = mysqli_fetch_all($typeres, MYSQLI_ASSOC);

$sql = "SELECT c.id, c.nom, c.course_type, c.date_course,
        u.nom as athlete_nom, u.prenom as athlete_prenom,
        COALESCE(i.temps_realise, '00:00:00') as temps_realise
        FROM courses c
        LEFT JOIN inscriptions i ON c.id = i.course_id
        LEFT JOIN users u ON i.user_id = u.id";

if (!empty($_GET['type'])) {
    $sql .= " WHERE c.course_type = '" . $_GET['type'] . "'";
}
if (!empty($_GET['date'])) {
    $sql .= isset($_GET['type']) ? " AND" : " WHERE";
    $sql .= " c.date_course = '" . $_GET['date'] . "'";
}
$sql .= " ORDER BY c.date_course DESC";

$result = mysqli_query($conn, $sql);
$courses = [];

while ($row = mysqli_fetch_assoc($result)) {
    if (!isset($courses[$row['id']])) {
        $courses[$row['id']] = [
            'nom' => $row['nom'],
            'type' => $row['course_type'],
            'date' => $row['date_course'],
            'resultats' => []
        ];
    }
    if ($row['athlete_nom']) {
        $courses[$row['id']]['resultats'][] = [
            'athlete' => $row['athlete_prenom'] . ' ' . $row['athlete_nom'],
            'temps' => $row['temps_realise']
        ];
    }
}

foreach ($courses as &$course) {
    if (!empty($course['resultats'])) {
        usort($course['resultats'], function($a, $b) {
            return strtotime($a['temps']) - strtotime($b['temps']);
        });
    }
}
unset($course);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats des Courses - Sprint Meet</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Réinitialisation et variables de couleur */
        :root {
            --primary-blue: #2980b9; /* Bleu principal */
            --secondary-red: #e74c3c; /* Rouge secondaire */
            --white: #fff;
            --light-gray: #f5f5f5;
            --medium-gray: #666; /* Gris moyen */
            --dark-blue: #1f6690; /* Bleu foncé pour survol */
            --dark-red: #b93c2f; /* Rouge foncé pour survol */
            --gold: gold;
            --silver: silver;
            --bronze: #cd7f32;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--light-gray);
            color: #333;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Titre principal */
        h1 {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-blue);
        }

        /* Section de filtre */
        .filter-section {
            background: var(--white);
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .filter-form {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }
        .filter-form select,
        .filter-form input[type="date"] {
            padding: 8px;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            font-size: 1rem;
            color: #333;
            background: var(--white);
        }
        .filter-form button {
            padding: 10px 20px;
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            border-radius: 4px;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        }
        .filter-form button:hover {
            background: var(--dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }
        .reset-btn {
            padding: 10px 20px;
            background: var(--secondary-red);
            color: var(--white);
            text-decoration: none;
            border-radius: 4px;
            font-weight: 700;
            text-transform: uppercase;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        }
        .reset-btn:hover {
            background: var(--dark-red);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }

        /* Carte de course */
        .course-card {
            background: var(--white);
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 15px;
        }
        .course-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .course-header h2 {
            color: var(--primary-blue);
            font-size: 1.5rem;
            font-weight: 700;
        }
        .course-info {
            color: var(--medium-gray);
            font-size: 0.9rem;
            margin-top: 5px;
        }

        /* Tableau des résultats */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background: var(--primary-blue);
            color: var(--white);
            padding: 10px;
            text-align: left;
            font-weight: 700;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            color: #333;
        }
        tr:hover {
            background: #f0f0f0;
        }
        .position {
            font-weight: 700;
        }
        tr:nth-child(1) .position { color: var(--gold); }
        tr:nth-child(2) .position { color: var(--silver); }
        tr:nth-child(3) .position { color: var(--bronze); }

        /* Message "Aucun résultat" */
        .no-results {
            text-align: center;
            color: var(--medium-gray);
            padding: 15px;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="filter-section">
        <form method="GET" class="filter-form">
            <select name="type">
                <option value="">Tous les types de courses</option>
                <?php foreach ($typescourse as $type): ?>
                    <option value="<?php echo htmlspecialchars($type['course_type']); ?>" 
                            <?php echo ($_GET['type'] ?? '') == $type['course_type'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($type['course_type']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="date" name="date" value="<?php echo htmlspecialchars($_GET['date'] ?? ''); ?>">
            <button type="submit">Filtrer</button>
            <a href="resultats_courses.php" class="reset-btn">Réinitialiser</a>
        </form>
    </div>

    <h1>Résultats des Courses</h1>
    
    <?php foreach ($courses as $course): ?>
        <div class="course-card">
            <div class="course-header">
                <h2><?php echo htmlspecialchars($course['nom']); ?></h2>
                <div class="course-info">
                    Type: <?php echo htmlspecialchars($course['type']); ?> | Date: <?php echo htmlspecialchars($course['date']); ?>
                </div>
            </div>
            <?php if (!empty($course['resultats'])): ?>
                <table>
                    <tr><th>Classement</th><th>Athlète</th><th>Temps</th></tr>
                    <?php 
                    $position = 1;
                    foreach ($course['resultats'] as $resultat): 
                        if ($resultat['temps']): 
                    ?>
                        <tr>
                            <td class="position"><?php echo $position++; ?></td>
                            <td><?php echo htmlspecialchars($resultat['athlete']); ?></td>
                            <td><?php echo htmlspecialchars($resultat['temps']); ?></td>
                        </tr>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </table>
            <?php else: ?>
                <div class="no-results">Aucun résultat disponible</div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>