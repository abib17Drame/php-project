<?php
// Connexion à la base de données
$connection = mysqli_connect('localhost', 'root', '', 'course_db');

// Vérifier si la connexion a réussi
if (mysqli_connect_error()) {
    die("La connexion a échoué : " . mysqli_connect_error());
}

// Récupérer l'ID de la course depuis l'URL
$course_id = $_GET['id'];

// Requête SQL pour récupérer les informations de la course
$sql_course = "SELECT * FROM courses WHERE id = $course_id";
$result_course = mysqli_query($connection, $sql_course);

// Vérifier si la requête a réussi
if (!$result_course) {
    die("Erreur dans la requête : " . mysqli_error($connection));
}

// Récupérer les informations de la course
$course = mysqli_fetch_assoc($result_course);

// Requête SQL pour récupérer les inscrits à la course
$sql_inscrits = "SELECT u.nom, u.prenom, u.email, u.profil 
                 FROM users u 
                 JOIN inscriptions i ON u.id = i.user_id 
                 WHERE i.course_id = $course_id";
$result_inscrits = mysqli_query($connection, $sql_inscrits);

// Vérifier si la requête a réussi
if (!$result_inscrits) {
    die("Erreur dans la requête : " . mysqli_error($connection));
}

// Récupérer tous les inscrits
$inscrits = [];
while ($row = mysqli_fetch_assoc($result_inscrits)) {
    $inscrits[] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscrits à la Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .inscrits-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .inscrits-table th, .inscrits-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        .inscrits-table th {
            background: #2c3e50;
            color: white;
        }
        h1, h2 {
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <h1>Inscrits à la course : <?php echo $course['nom']; ?></h1>
    <h2>Date : <?php echo $course['date_course']; ?></h2>

    <table class="inscrits-table">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Profil</th>
        </tr>
        <?php foreach ($inscrits as $inscrit): ?>
            <tr>
                <td><?php echo $inscrit['nom']; ?></td>
                <td><?php echo $inscrit['prenom']; ?></td>
                <td><?php echo $inscrit['email']; ?></td>
                <td><?php echo $inscrit['profil']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="courses.php">Retour à la liste des courses</a>
</body>
</html>