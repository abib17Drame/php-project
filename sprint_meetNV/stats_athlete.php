<?php
session_start();
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

// Vérifie si l'utilisateur est connecté et est un athlète
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Récupérer les performances de l'athlète
$sql = "SELECT MIN(p.temps) AS meilleur_temps, 
               AVG(p.temps) AS moyenne_temps
        FROM performances p
        JOIN inscriptions i ON p.inscription_id = i.id
        WHERE i.user_id = $user_id AND p.temps IS NOT NULL";
$result = mysqli_query($conn, $sql);
$performance = mysqli_fetch_assoc($result);

// Récupérer le classement de l'athlète basé sur le meilleur temps
$sql = "SELECT i.user_id, MIN(p.temps) AS meilleur_temps
        FROM performances p
        JOIN inscriptions i ON p.inscription_id = i.id
        WHERE p.temps IS NOT NULL
        GROUP BY i.user_id
        ORDER BY meilleur_temps ASC";
$result = mysqli_query($conn, $sql);
$classement = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Trouver le rang de l'athlète
$rang = "Non classé";
foreach ($classement as $index => $row) {
    if ($row['user_id'] == $user_id) {
        $rang = $index + 1;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Statistiques</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="scripts/mescourses.php">Courses inscrit</a></li>
            <li><a href="results.php">Résultats</a></li>
            <li><a href="mes_stats.html">Statistiques</a></li>
            <li><a href="scripts/choix_course.php">S'inscrire à une course</a></li>
            <li><a href="scripts/logout.php">Déconnexion</a></li>
        </ul>
    </nav>
    
    <center><h1>Mes Statistiques</h1></center>
    
    <section>
        <h2>Évolution des performances</h2>
        <?php if ($performance['meilleur_temps']): ?>
            <p><strong>Meilleur temps :</strong> <?php echo number_format($performance['meilleur_temps'], 2); ?> sec</p>
            <p><strong>Temps moyen :</strong> <?php echo number_format($performance['moyenne_temps'], 2); ?> sec</p>
        <?php else: ?>
            <div class="aucune-donnee">Aucune donnée pour l’instant</div>
        <?php endif; ?>
    </section>

    <section>
        <h2>Comparaison avec d’autres athlètes</h2>
        <?php if (!empty($classement)): ?>
            <p><strong>Classement général :</strong> Vous êtes classé <strong>#<?php echo $rang; ?></strong> parmi les meilleurs athlètes.</p>
        <?php else: ?>
            <div class="aucune-donnee">Aucune donnée pour l’instant</div>
        <?php endif; ?>
    </section>

    <section>
        <h2>Meilleur classement obtenu</h2>
        <p><strong>Votre meilleur classement :</strong> <?php echo ($rang !== "Non classé") ? "#$rang" : "Non classé"; ?></p>
    </section>

</body>
</html>