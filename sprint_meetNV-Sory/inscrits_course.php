<?php
include 'includes/db_connect.php';

$course_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['couloir'] as $inscription_id => $couloir) {
        $sql = "UPDATE inscriptions SET couloir = $couloir WHERE id = $inscription_id";
        mysqli_query($conn, $sql);
    }
    echo "<p>Les couloirs ont été mis à jour avec succès !</p>";
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
    <title>Inscrits à la Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
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

    <form method="POST" action="">
        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Profil</th>
                <th>Couloir</th>
            </tr>
            <?php foreach ($inscrits as $inscrit): ?>
                <tr>
                    <td><?php echo $inscrit['nom']; ?></td>
                    <td><?php echo $inscrit['prenom']; ?></td>
                    <td><?php echo $inscrit['email']; ?></td>
                    <td><?php echo $inscrit['profil']; ?></td>
                    <td>
                        <input type="number" 
                               name="couloir[<?php echo $inscrit['id']; ?>]" 
                               value="<?php echo $inscrit['couloir']; ?>"
                               min="1" max="8" required>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit">Enregistrer les couloirs</button>
    </form>

    <a href="courses.php">Retour à la liste des courses</a>
</body>
</html>