<?php
session_start();
require_once '../includes/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'athlete') {
    header("Location: ../login.html");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT nom, prenom, age, pays, club, record_officiel, 
                                  diplome, piece_identite, fichier_record 
                           FROM users 
                           WHERE id = :user_id");
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* Navigation */
        nav {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            padding: 15px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 20px;
            transition: background-color 0.3s, transform 0.3s;
            border-radius: 25px;
        }

        nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        /* Section des informations */
        #infos {
            padding: 30px;
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
            background-image: url('https://via.placeholder.com/800x400?text=Mes+Informations');
            background-size: cover;
            background-position: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        #infos::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        #infos h1,
        #infos p,
        #infos .info-box {
            position: relative;
            z-index: 2;
        }

        #infos h1 {
            color: #fff;
            font-size: 32px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        #infos p {
            font-size: 18px;
            margin-bottom: 20px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        .info-box {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
            color: #333;
        }

        .info-box p {
            margin: 10px 0;
            font-size: 16px;
        }

        .info-box strong {
            color: #2c3e50;
        }

        /* Responsive */
        @media (max-width: 600px) {
            nav ul {
                flex-direction: column;
                align-items: center;
            }

            nav ul li {
                margin: 10px 0;
            }

            #infos {
                padding: 20px;
                margin: 20px;
            }

            #infos h1 {
                font-size: 28px;
            }

            #infos p {
                font-size: 16px;
            }

            .info-box p {
                font-size: 14px;
            }
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
            <p><strong>Nom :</strong> <span><?php echo htmlspecialchars($user['prenom'] . " " . $user['nom']); ?></span></p>
            <p><strong>Âge :</strong> <span><?php echo htmlspecialchars($user['age'] ?? 'Non renseigné'); ?></span></p>
            <p><strong>Pays :</strong> <span><?php echo htmlspecialchars($user['pays'] ?? 'Non renseigné'); ?></span></p>
            <p><strong>Club :</strong> <span><?php echo htmlspecialchars($user['club'] ?? 'Non renseigné'); ?></span></p>
            <p><strong>Record personnel :</strong> <span><?php echo htmlspecialchars($user['record_officiel'] ?? '00:00:00'); ?></span></p>
            <p><strong>Diplôme :</strong> <?php echo afficherLienFichier($user['diplome'], "Voir diplôme"); ?></p>
            <p><strong>Pièce d'identité :</strong> <?php echo afficherLienFichier($user['piece_identite'], "Voir pièce d'identité"); ?></p>
            <p><strong>Fichier record :</strong> <?php echo afficherLienFichier($user['fichier_record'], "Voir fichier record"); ?></p>
        </div>
    </section>

</body>
</html>
