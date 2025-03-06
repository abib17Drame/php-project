<?php
require_once 'includes/db_connect.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_type = $_POST['course_type'];
    $round_type = $_POST['round_type'];
    $date = $_POST['date'];
    $gender = $_POST['gender'];
    $statut = $_POST['statut'];

    // Generate course name based on type and gender
    $nom = $course_type . " " . $gender;

    $sql = "UPDATE courses SET nom = ?, course_type = ?, round_type = ?, date_course = ?, statut_inscription = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $nom, $course_type, $round_type, $date, $statut, $id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: courses.php');
        exit;
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}

// Get current course information
$sql = "SELECT * FROM courses WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$course = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une Course</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: bold;
        }
        select, input {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        button {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .retour {
            display: inline-block;
            padding: 12px 25px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Modifier la Course</h1>
    
    <form method="POST">
        <div class="form-group">
            <label>Type de course</label>
            <select name="course_type" required>
                <option value="Sprint100m" <?php echo ($course['course_type'] == 'Sprint100m') ? 'selected' : ''; ?>>Sprint 100m</option>
                <option value="Sprint120m" <?php echo ($course['course_type'] == 'Sprint120m') ? 'selected' : ''; ?>>Sprint 120m</option>
                <option value="Haies100m" <?php echo ($course['course_type'] == 'Haies100m') ? 'selected' : ''; ?>>Haies 100m</option>
                <option value="Relais4x100m" <?php echo ($course['course_type'] == 'Relais4x100m') ? 'selected' : ''; ?>>Relais 4x100m</option>
                <option value="Relais4x400m" <?php echo ($course['course_type'] == 'Relais4x400m') ? 'selected' : ''; ?>>Relais 4x400m</option>
                <option value="Autre" <?php echo ($course['course_type'] == 'Autre') ? 'selected' : ''; ?>>Autre</option>
            </select>
        </div>

        <div class="form-group">
            <label>Type de tour</label>
            <select name="round_type" required>
                <option value="Series" <?php echo ($course['round_type'] == 'Series') ? 'selected' : ''; ?>>Séries</option>
                <option value="DemiFinale" <?php echo ($course['round_type'] == 'DemiFinale') ? 'selected' : ''; ?>>Demi-Finale</option>
                <option value="Finale" <?php echo ($course['round_type'] == 'Finale') ? 'selected' : ''; ?>>Finale</option>
            </select>
        </div>

        <div class="form-group">
            <label>Catégorie</label>
            <select name="gender" required>
                <option value="Homme" <?php echo (strpos($course['nom'], 'Homme') !== false) ? 'selected' : ''; ?>>Homme</option>
                <option value="Femme" <?php echo (strpos($course['nom'], 'Femme') !== false) ? 'selected' : ''; ?>>Femme</option>
            </select>
        </div>

        <div class="form-group">
            <label>Statut</label>
            <select name="statut" required>
                <option value="ouvert" <?php echo ($course['statut_inscription'] == 'ouvert') ? 'selected' : ''; ?>>Ouvert</option>
                <option value="ferme" <?php echo ($course['statut_inscription'] == 'ferme') ? 'selected' : ''; ?>>Fermé</option>
            </select>
        </div>

        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" value="<?php echo $course['date_course']; ?>" required>
        </div>

        <button type="submit">Modifier</button>
        <a href="courses.php" class="retour">Retour</a>
    </form>
</body>
</html>