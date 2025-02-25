<?php
require_once 'includes/db_connect.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE courses SET nom = ?, date_course = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nom'],
        $_POST['date'],
        $id
    ]);
    header('Location: courses.php');
    exit;
}

$sql = "SELECT * FROM courses WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$course = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Modifier la Course</h1>
    
    <form method="POST">
        <div class="form-group">
            <label>Nom de la course</label>
            <input type="text" name="nom" value="<?= $course['nom'] ?>" required>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" value="<?= $course['date_course'] ?>" required>
        </div>
        <button type="submit">Modifier</button>
        <a href="courses.php">Retour</a>
    </form>
</body>
</html>
