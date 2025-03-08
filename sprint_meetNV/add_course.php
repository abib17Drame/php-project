<?php
require_once 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_type = $_POST['course_type'];
    $round_type = $_POST['round_type'];
    $date = $_POST['date'];
    $gender = $_POST['gender'];
    $statut = $_POST['statut'];

    // Generate course name based on type and gender
    $nom = $course_type . " " . $gender;

    $sql = "INSERT INTO courses (nom, course_type, round_type, date_course, statut_inscription) 
            VALUES (?, ?, ?, ?, ?)";
            
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $nom, $course_type, $round_type, $date, $statut);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: courses.php');
        exit;
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une Course</title>
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
            transition: border-color 0.3s;
        }
        select:focus, input:focus {
            border-color: #3498db;
            outline: none;
        }
        button {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: transform 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
        }
        .retour {
            display: inline-block;
            padding: 12px 25px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .retour:hover {
            background: #2980b9;
        }
        .accueil {
            display: inline-block;
            padding: 12px 25px;
            background: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            margin-left: 10px;
            transition: background-color 0.3s;
        }
        .accueil:hover {
            background: #219653;
        }
    </style>
</head>
<body>
    <h1>Ajouter une Course</h1>
    
    <form method="POST">
        <div class="form-group">
            <label>Type de course</label>
            <select name="course_type" required>
                <option value="Sprint100m">Sprint 100m</option>
                <option value="Sprint120m">Sprint 200m</option>
                <option value="Sprint400m">Sprint 400m</option>
                <option value="Haies100m">Haies 100m</option>
                <option value="Haies110m">Haies 110m</option>
                <option value="Haies400m">Haies 400m</option>
                <option value="Relais4x100m">Relais 4x100m</option>
                <option value="Relais4x400m">Relais 4x400m</option>
                <option value="Autre">Autre</option>
            </select>
        </div>

        <div class="form-group">
            <label>Type de tour</label>
            <select name="round_type" required>
                <option value="Series">Séries</option>
                <option value="DemiFinale">Demi-Finale</option>
                <option value="Finale">Finale</option>
            </select>
        </div>

        <div class="form-group">
            <label>Catégorie</label>
            <select name="gender" required>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
            </select>
        </div>

        <div class="form-group">
            <label>Statut</label>
            <select name="statut" required>
                <option value="ouvert">Ouvert</option>
                <option value="fermé">Fermé</option>
            </select>
        </div>

        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" required>
        </div>

        <button type="submit">Ajouter la course</button>
    </form>
    
    <a href="courses.php" class="retour">Retour à la liste</a>
    <a href="dashboard_admin.php" class="retour">Retour au tableau de bord</a>
</body>
</html>