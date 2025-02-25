<?php
require_once 'includes/db_connect.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE users SET 
            nom = ?,
            prenom = ?,
            email = ?,
            identifiant = ?
            WHERE id = ? AND role = 'arbitre'";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['email'],
        $_POST['identifiant'],
        $id
    ]);
    
    header('Location: arbitres.php');
    exit;
}

$sql = "SELECT * FROM users WHERE id = ? AND role = 'arbitre'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$arbitre = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Arbitre</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #2ecc71; color: white; padding: 10px 20px; border: none; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Modifier l'arbitre</h1>
    
    <form method="POST">
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="nom" value="<?= $arbitre['nom'] ?>" required>
        </div>
        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="prenom" value="<?= $arbitre['prenom'] ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= $arbitre['email'] ?>" required>
        </div>
        <div class="form-group">
            <label>Identifiant</label>
            <input type="text" name="identifiant" value="<?= $arbitre['identifiant'] ?>" required>
        </div>
        <button type="submit">Enregistrer</button>
        <a href="arbitres.php">Annuler</a>
    </form>
</body>
</html>
