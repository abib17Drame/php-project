<?php
require_once 'includes/db_connect.php'; // Inclut le fichier de connexion à la base de données

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $profil = $_POST['profil'];
    $sexe = $_POST['sexe'];

    // Requête SQL pour mettre à jour l'athlète
    $sql = "UPDATE users SET 
            nom = '$nom',
            prenom = '$prenom',
            email = '$email',
            profil = '$profil',
            sexe = '$sexe'
            WHERE id = $id AND role = 'athlete'";
    
    // Exécute la requête
    if (mysqli_query($conn, $sql)) {
        header('Location: athletes.php');
        exit;
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}

// Récupérer les informations de l'athlète
$sql = "SELECT * FROM users WHERE id = $id AND role = 'athlete'";
$result = mysqli_query($conn, $sql);
$athlete = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Athlète</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: Arial; max-width: 600px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #2ecc71; color: white; padding: 10px 20px; border: none; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Modifier l'athlète</h1>
    
    <form method="POST">
        <div class="form-group">
            <label>Nom:</label>
            <input type="text" name="nom" value="<?php echo $athlete['nom']; ?>" required>
        </div>
        <div class="form-group">
            <label>Prénom:</label>
            <input type="text" name="prenom" value="<?php echo $athlete['prenom']; ?>" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $athlete['email']; ?>" required>
        </div>
        <div class="form-group">
            <label>Profil:</label>
            <select name="profil">
                <option value="individuel" <?php echo $athlete['profil'] == 'individuel' ? 'selected' : ''; ?>>Individuel</option>
                <option value="equipe" <?php echo $athlete['profil'] == 'equipe' ? 'selected' : ''; ?>>Équipe</option>
            </select>
        </div>
        <div class="form-group">
            <label>Genre:</label>
            <select name="sexe">
                <option value="homme" <?php echo $athlete['sexe'] == 'homme' ? 'selected' : ''; ?>>Homme</option>
                <option value="femme" <?php echo $athlete['sexe'] == 'femme' ? 'selected' : ''; ?>>Femme</option>
            </select>
        </div>
        <button type="submit">Enregistrer</button>
        <a href="athletes.php">Annuler</a>
    </form>
</body>
</html>