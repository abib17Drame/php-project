<?php
session_start();
require_once '../includes/db_connect.php';

// Vérifie si l'utilisateur est connecté et est un athlète
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: ../login.html");
    exit;
}

// Récupère les informations de l'utilisateur
$user_id = $_SESSION['user_id'];
$sql = "SELECT nom, prenom, age, pays, club, record_officiel, diplome, piece_identite, fichier_record 
        FROM users 
        WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Fonction pour afficher un lien de téléchargement si un fichier est présent
function afficherLienFichier($fichier, $label) {
    if (!empty($fichier)) {
        return "<a href='../uploads/$fichier' target='_blank' class='download-link'>$label</a>";
    } else {
        return "<span class='no-data'>Non disponible</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Informations</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Style général */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #333;
            padding: 10px;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        #infos {
            background-color: white;
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .info-box {
            margin-top: 20px;
        }

        .info-box p {
            margin: 10px 0;
        }

        .download-link {
            color: blue;
            text-decoration: underline;
        }

        .no-data {
            color: gray;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="../dashboard_athlete.html">Tableau de bord</a></li>
            <li><a href="mescourses.php">Mes courses</a></li>
            <li><a href="../results.php">Résultats</a></li>
            <li><a href="mes_stats.html">Statistiques</a></li>
            <li><a href="choix_course.php">S'inscrire à une course</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <section id="infos">
        <h1>Mes Informations</h1>
        <p>Voici vos informations personnelles.</p>

        <div class="info-box">
            <p><strong>Nom :</strong> <?php echo $user['prenom'] . " " . $user['nom']; ?></p>
            <p><strong>Âge :</strong> <?php echo $user['age'] ?? 'Non renseigné'; ?></p>
            <p><strong>Pays :</strong> <?php echo $user['pays'] ?? 'Non renseigné'; ?></p>
            <p><strong>Club :</strong> <?php echo $user['club'] ?? 'Non renseigné'; ?></p>
            <p><strong>Record personnel :</strong> <?php echo $user['record_officiel'] ?? '00:00:00'; ?></p>
            <p><strong>Diplôme :</strong> <?php echo afficherLienFichier($user['diplome'], "Voir diplôme"); ?></p>
            <p><strong>Pièce d'identité :</strong> <?php echo afficherLienFichier($user['piece_identite'], "Voir pièce d'identité"); ?></p>
            <p><strong>Fichier record :</strong> <?php echo afficherLienFichier($user['fichier_record'], "Voir fichier record"); ?></p>
        </div>
    </section>
</body>
</html>