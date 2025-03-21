<?php
include '../includes/db_connect.php';

$course_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['couloir'] as $inscription_id => $couloir) {
        $sql = "UPDATE inscriptions SET couloir = $couloir WHERE id = $inscription_id";
        mysqli_query($conn, $sql);
    }
    echo "<p class='success-message'>Les couloirs ont été mis à jour avec succès !</p>";
}

$sql_course = "SELECT * FROM courses WHERE id = $course_id";
$result_course = mysqli_query($conn, $sql_course);

if (!$result_course) {
    die("Erreur dans la requête : " . mysqli_error($conn));
}

$course = mysqli_fetch_assoc($result_course);

$sql_inscrits = "SELECT i.id, u.nom, u.prenom, u.email, u.profil, i.couloir 
                 FROM users u
                 JOIN inscriptions i ON u.id = i.user_id
                 WHERE i.course_id = $course_id";
$result_inscrits = mysqli_query($conn, $sql_inscrits);

if (!$result_inscrits) {
    die("Erreur dans la requête : " . mysqli_error($conn));
}

$inscrits = [];
while ($row = mysqli_fetch_assoc($result_inscrits)) {
    $inscrits[] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrits à la Course - Sprint Meet</title>
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
            max-width: 1000px;
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
        h2 {
            font-size: 1.2rem;
            color: var(--white);
            margin-top: 5px;
        }

        /* Message de succès */
        .success-message {
            background: #27ae60;
            color: var(--white);
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }

        /* Tableau */
        .inscrits-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .inscrits-table th, .inscrits-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .inscrits-table th {
            background-color: var(--primary-blue);
            color: var(--white);
        }
        .inscrits-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .inscrits-table tr:hover {
            background-color: #e0e7ff;
        }
        .inscrits-table input[type="number"] {
            width: 60px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Boutons */
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
            display: inline-block;
            background: var(--secondary-red);
            margin-top: 20px;
        }
        .btn-retour:hover {
            background: #c0392b;
            transform: translateY(-3px);
        }

        /* Design responsive */
        @media (max-width: 600px) {
            .inscrits-table th, .inscrits-table td {
                padding: 8px;
                font-size: 0.9rem;
            }
            .btn {
                padding: 10px 20px;
            }
            h1 {
                font-size: 1.5rem;
            }
            h2 {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Inscrits à la course : <?php echo $course['nom']; ?></h1>
        <h2>Date : <?php echo $course['date_course']; ?></h2>
    </header>

    <form method="POST" action="">
        <table class="inscrits-table">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Profil</th>
                <th>Couloir</th>
            </tr>
            <?php foreach ($inscrits as $inscrit): ?>
                <tr>
                    <td><?php echo htmlspecialchars($inscrit['nom']); ?></td>
                    <td><?php echo htmlspecialchars($inscrit['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($inscrit['email']); ?></td>
                    <td><?php echo htmlspecialchars($inscrit['profil']); ?></td>
                    <td>
                        <input type="number" 
                               name="couloir[<?php echo $inscrit['id']; ?>]" 
                               value="<?php echo $inscrit['couloir']; ?>"
                               min="1" max="8" required>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit" class="btn btn-save">Enregistrer les couloirs</button>
    </form>

    <a href="courses.php" class="btn btn-retour">Retour à la liste des courses</a>
</body>
</html>