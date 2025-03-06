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
    <title>Mes Informations</title>
    
    <style>
        /* Style général */
        body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f7f6;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .container {
      max-width: 1100px;
      margin: 0px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h1 {
      color: #2c3e50;
      font-size: 2.5rem;
      margin-bottom: 20px;
    }

        

        nav ul {
      list-style: none;
      display: flex;
      justify-content: center;
      padding: 0;
      background: #2c3e50;
      border-radius: 8px;
      margin-bottom: 30px;
      
    }
    nav ul li {
      margin: 0 15px;
    }
    nav ul li a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      padding: 15px 20px;
      display: block;
      transition: background 0.3s, transform 0.3s;
    }
    nav ul li a:hover {
      background: #34495e;
      transform: translateY(-3px);
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
    <div class="container">
    <nav>
        <ul>
            <li><a href="../dashboard_athlete.php">Tableau de bord</a></li>
            <li><a href="mescourses.php">Mes courses</a></li>
            <li><a href="../results.php">Résultats</a></li>
            
            <li><a href="choix_course.php">S'inscrire à une course</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>
    </div>
    <section id="infos">
        <h1>Mes Informations</h1>
        <p>Voici vos informations personnelles.</p>

        <div class="info-box">
            <p><strong>Nom :</strong> <?php echo $user['prenom'] . " " . $user['nom']; ?></p>
            <p><strong>Âge :</strong> <?php echo $user['age'] ?? 'Non renseigné'; ?></p>
            <p><strong>Pays :</strong> <?php echo $user['pays'] ?? 'Non renseigné'; ?></p>
        
            
    </section>
</body>
</html>