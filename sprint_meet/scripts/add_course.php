<?php
session_start();
require_once '../includes/db_connect.php';

// Pour le développement : afficher les erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom         = $_POST['nom'] ?? '';
    $course_type = $_POST['course_type'] ?? '';
    $round_type  = $_POST['round_type'] ?? '';
    $date_course = $_POST['date_course'] ?? '';

    if ($nom && $course_type && $round_type && $date_course) {
        try {
            $sql = "INSERT INTO courses (nom, course_type, round_type, date_course)
                    VALUES (:nom, :course_type, :round_type, :date_course)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':course_type' => $course_type,
                ':round_type' => $round_type,
                ':date_course' => $date_course
            ]);
            $message = "Course ajoutée avec succès !";
        } catch (PDOException $e) {
            $message = "Erreur lors de l'ajout de la course : " . $e->getMessage();
        }
    } else {
        $message = "Tous les champs sont requis.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Course</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Ajouter une Course</h1>
    <?php if ($message): ?>
      <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form action="add_course.php" method="post">
        <label for="nom">Nom de la course :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="course_type">Type de course :</label>
        <select id="course_type" name="course_type" required>
            <option value="">Choisissez le type</option>
            <option value="Sprint100m">Sprint 100m</option>
            <option value="Sprint120m">Sprint 120m</option>
            <option value="Haies100m">Haies 100m</option>
            <option value="Relais4x100m">Relais 4x100m</option>
        </select>

        <label for="round_type">Phase de la course :</label>
        <select id="round_type" name="round_type" required>
            <option value="">Choisissez la phase</option>
            <option value="Series">Séries</option>
            <option value="DemiFinale">Demi-Finale</option>
            <option value="Finale">Finale</option>
        </select>

        <label for="date_course">Date de la course :</label>
        <input type="date" id="date_course" name="date_course" required>

        <button type="submit">Ajouter la course</button>
    </form>
</body>
</html>
