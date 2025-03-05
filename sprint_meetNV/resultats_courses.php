<?php
require_once 'includes/db_connect.php';

$sql_types = "SELECT DISTINCT course_type FROM courses";
$typeres = mysqli_query($conn, $sql_types);
$typescourse = mysqli_fetch_all($typeres, MYSQLI_ASSOC);

$sql = "SELECT c.id, c.nom, c.course_type, c.date_course,
        u.nom as athlete_nom, u.prenom as athlete_prenom,
        i.temps_realise
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

// Organisation des données
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

// Trier les résultats de chaque course par temps croissant (temps le plus court en premier)
// Attention : ici nous supposons que les temps sont dans un format reconnu par strtotime (par ex. "H:i:s" ou "i:s")
foreach ($courses as &$course) {
    if (!empty($course['resultats'])) {
        usort($course['resultats'], function($a, $b) {
            // Utiliser strtotime si le format du temps est compatible
            return strtotime($a['temps']) - strtotime($b['temps']);
            // Si vos temps sont en secondes (format numérique), vous pouvez utiliser :
            // return $a['temps'] - $b['temps'];
        });
    }
}
unset($course); // libérer la référence

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats des Courses - Sprint Meet</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .filter-form {
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: center;
        }
        .filter-form select,
        .filter-form input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .filter-form button {
            padding: 10px 20px;
            background: #2196F3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .reset-btn {
            padding: 10px 20px;
            background: #666;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .course-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            padding: 20px;
        }
        .course-header {
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .course-header h2 {
            color: #333;
            margin: 0;
        }
        .course-info {
            color: #666;
            font-size: 0.9em;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th {
            background-color: #f8f9fa;
            color: #333;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .position {
            font-weight: bold;
            color: #2196F3;
        }
        .no-results {
            text-align: center;
            color: #666;
            padding: 20px;
        }
        tr:hover {
            background-color: #f8f9fa;
        }
        button:hover,
        .reset-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="filter-section">
        <form method="GET" class="filter-form">
            <select name="type">
                <option value="">Tous les types de courses</option>
                <?php foreach ($typescourse as $type): ?>
                    <option value="<?php echo $type['course_type']; ?>" 
                            <?php echo ($_GET['type'] ?? '') == $type['course_type'] ? 'selected' : ''; ?>>
                        <?php echo $type['course_type']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="date" name="date" value="<?php echo $_GET['date'] ?? ''; ?>">
            <button type="submit">Filtrer</button>
            <a href="resultats_courses.php" class="reset-btn">Réinitialiser</a>
        </form>
    </div>

    <h1>Résultats des Courses</h1>
    
    <?php foreach ($courses as $course): ?>
        <div class="course-card">
            <div class="course-header">
                <h2><?php echo $course['nom']; ?></h2>
                <div class="course-info">
                    Type: <?php echo $course['type']; ?> | Date: <?php echo $course['date']; ?>
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
                            <td><?php echo $resultat['athlete']; ?></td>
                            <td><?php echo $resultat['temps']; ?></td>
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
