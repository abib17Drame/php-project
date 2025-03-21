<?php
require_once '../includes/db_connect.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Course - Sprint Meet</title>
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
            max-width: 800px;
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

        /* Formulaire */
        .form-container {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary-blue);
            font-weight: bold;
        }
        select, input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .btn {
            padding: 12px 25px;
            border-radius: 4px;
            cursor: pointer;
            color: var(--white);
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-save {
            background: var(--primary-blue);
            border: none;
        }
        .btn-save:hover {
            background: #1f6690;
            transform: translateY(-3px);
        }
        .btn-retour {
            background: var(--secondary-red);
            margin-left: 10px;
        }
        .btn-retour:hover {
            background: #c0392b;
            transform: translateY(-3px);
        }

        /* Design responsive */
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            h1 {
                font-size: 1.5rem;
            }
            .form-container {
                padding: 20px;
            }
            .btn {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Modifier la Course</h1>
    </header>

    <div class="form-container">
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

            <button type="submit" class="btn btn-save">Modifier</button>
            <a href="courses.php" class="btn btn-retour">Retour</a>
        </form>
    </div>
</body>
</html>