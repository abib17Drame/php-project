<?php
require_once 'includes/db_connect.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE users SET 
            nom = '" . $_POST['nom'] . "',
            prenom = '" . $_POST['prenom'] . "',
            email = '" . $_POST['email'] . "',
            profil = '" . $_POST['profil'] . "',
            sexe = '" . $_POST['sexe'] . "'
            WHERE id = $id";
    
    $pdo->query($sql);
    header('Location: athletes.php');
    exit;
}

$sql = "SELECT * FROM users WHERE id = $id AND role = 'athlete'";
$stmt = $pdo->query($sql);
$athlete = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Athlète</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Modifier l'athlète</h1>
    
    <form method="POST">
        <div>
            <label>Nom:</label>
            <input type="text" name="nom" value="<?= $athlete['nom'] ?>" required>
        </div>
        <div>
            <label>Prénom:</label>
            <input type="text" name="prenom" value="<?= $athlete['prenom'] ?>" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="<?= $athlete['email'] ?>" required>
        </div>
        <div>
            <label>Profil:</label>
            <select name="profil">
                <option value="individuel" <?= $athlete['profil'] == 'individuel' ? 'selected' : '' ?>>Individuel</option>
                <option value="equipe" <?= $athlete['profil'] == 'equipe' ? 'selected' : '' ?>>Équipe</option>
            </select>
        </div>
        <div>
            <label>Genre:</label>
            <select name="sexe">
                <option value="homme" <?= $athlete['sexe'] == 'homme' ? 'selected' : '' ?>>Homme</option>
                <option value="femme" <?= $athlete['sexe'] == 'femme' ? 'selected' : '' ?>>Femme</option>
            </select>
        </div>
        <button type="submit">Enregistrer</button>
        <a href="athletes.php">Annuler</a>
    </form>
</body>
</html>
