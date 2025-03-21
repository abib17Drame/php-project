<?php
require_once '../includes/db_connect.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Course - Sprint Meet</title>
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

        /* Formulaire */
        .form-container {
            background: var(--white);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
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
            transition: border-color 0.3s ease;
        }
        select:focus, input:focus {
            border-color: var(--primary-blue);
            outline: none;
        }

        /* Boutons */
        .btn {
            padding: 10px 20px;
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
        .btn-submit {
            background-color: var(--primary-blue);
            border: none;
            width: 100%;
            font-size: 1rem;
        }
        .btn-submit:hover {
            background-color: #1f6690;
            transform: translateY(-3px);
        }
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
        .retour i {
            margin-right: 5px;
        }

        /* Responsive Design */
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
            .btn, .retour {
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Ajouter une Course</h1>
    </header>

    <div class="form-container">
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

            <button type="submit" class="btn btn-submit"><i class="fas fa-plus"></i> Ajouter la course</button>
        </form>

        <a href="courses.php" class="retour"><i class="fas fa-arrow-left"></i> Retour à la liste</a>
        <a href="dashboard_admin.php" class="retour"><i class="fas fa-tachometer-alt"></i> Retour au tableau de bord</a>
    </div>
</body>
</html>