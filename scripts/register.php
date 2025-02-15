<?php
require_once '../includes/db_connect.php';

$profil = $_POST['profil'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$nom = $_POST['nom'] ?? '';
$email = $_POST['email'] ?? '';
$mot_de_passe = $_POST['mot_de_passe'] ?? '';

$hashedPassword = password_hash($mot_de_passe, PASSWORD_DEFAULT);

$role = ($profil === 'arbitre') ? 'arbitre' : 'athlete';

$sexe = $_POST['sexe'] ?? '';
$discipline = $_POST['discipline'] ?? '';
$age = $_POST['age'] ?? null;
$pays = $_POST['pays'] ?? '';
$record = $_POST['record'] ?? '00:00:00';

try {
    $sql = "INSERT INTO users (nom, prenom, email, mot_de_passe, role, sexe, age, pays, record_officiel)
            VALUES (:nom, :prenom, :email, :mdp, :role, :sexe, :age, :pays, :record_officiel)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':mdp' => $hashedPassword,
        ':role' => $role,
        ':sexe' => $sexe,
        ':age' => $age,
        ':pays' => $pays,
        ':record_officiel' => $record
    ]);
    echo "Inscription réussie ! <a href='../login.html'>Se connecter</a>";
} catch(PDOException $e) {
    echo "Erreur lors de l'inscription : " . $e->getMessage();
}
