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
$sql = "SELECT nom, prenom, age, pays
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
    <title>Mes Informations - Sprint Meet</title>
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

        /* Section des informations */
        .info-section {
            background: var(--white);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        .info-section p.intro {
            color: #7f8c8d;
            font-size: 1rem;
            margin-bottom: 20px;
        }
        .info-box {
            margin-top: 20px;
            text-align: left;
        }
        .info-box p {
            margin: 15px 0;
            font-size: 1rem;
            color: #333;
        }
        .info-box p strong {
            color: var(--primary-blue);
            font-weight: bold;
        }
        .download-link {
            color: var(--primary-blue);
            text-decoration: underline;
            transition: color 0.3s ease;
        }
        .download-link:hover {
            color: #1f6690;
        }
        .no-data {
            color: #7f8c8d;
            font-style: italic;
        }

        /* Lien Retour */
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
            .info-section {
                padding: 20px;
            }
            .info-box p {
                font-size: 0.9rem;
            }
            .retour {
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Mes Informations</h1>
    </header>

    <section class="info-section">
        <p class="intro">Voici vos informations personnelles.</p>
        <div class="info-box">
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['prenom'] . " " . $user['nom']); ?></p>
            <p><strong>Âge :</strong> <?php echo htmlspecialchars($user['age'] ?? 'Non renseigné'); ?></p>
            <p><strong>Pays :</strong> <?php echo htmlspecialchars($user['pays'] ?? 'Non renseigné'); ?></p>
        </div>
        <a href="dashboard_athlete.php" class="retour"><i class="fas fa-arrow-left"></i> Retour au tableau de bord</a>
    </section>
</body>
</html>