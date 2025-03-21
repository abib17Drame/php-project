<?php
require_once '../includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $identifiant = $_POST['identifiant'];

    // Requête SQL pour mettre à jour l'arbitre
    $sql = "UPDATE users SET 
            nom = '$nom',
            prenom = '$prenom',
            email = '$email',
            identifiant = '$identifiant'
            WHERE id = $id AND role = 'arbitre'";
    
    // Exécute la requête
    if (mysqli_query($conn, $sql)) {
        header('Location: arbitres.php');
        exit;
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}

// Récupérer les informations de l'arbitre
$sql = "SELECT * FROM users WHERE id = $id AND role = 'arbitre'";
$result = mysqli_query($conn, $sql);
$arbitre = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Arbitre - Sprint Meet</title>
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
            max-width: 600px;
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

        /* Formulaire */
        .form-container {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: var(--primary-blue);
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .btn {
            padding: 10px 20px;
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
        .btn-cancel {
            background: var(--secondary-red);
            margin-left: 10px;
        }
        .btn-cancel:hover {
            background: #c0392b;
            transform: translateY(-3px);
        }

        /* Design responsive */
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            h1 {
                font-size: 1.5rem;
            }
            .form-container {
                padding: 15px;
            }
            .btn {
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Modifier l'arbitre</h1>
    </header>

    <div class="form-container">
        <form method="POST">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" value="<?php echo htmlspecialchars($arbitre['nom']); ?>" required>
            </div>
            <div class="form-group">
                <label>Prénom</label>
                <input type="text" name="prenom" value="<?php echo htmlspecialchars($arbitre['prenom']); ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($arbitre['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Identifiant</label>
                <input type="text" name="identifiant" value="<?php echo htmlspecialchars($arbitre['identifiant']); ?>" required>
            </div>
            <button type="submit" class="btn btn-save">Enregistrer</button>
            <a href="arbitres.php" class="btn btn-cancel">Annuler</a>
        </form>
    </div>
</body>
</html>