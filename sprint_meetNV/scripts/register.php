<?php
require_once '../includes/db_connect.php';

// Champs communs
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$email = $_POST['email'] ?? '';
$mot_de_passe = $_POST['mot_de_passe'] ?? '';
$hashedPassword = password_hash($mot_de_passe, PASSWORD_DEFAULT);

// Détermination du type d'inscription
// Si le champ "identifiant" est renseigné, c'est un arbitre
if (isset($_POST['identifiant']) && !empty($_POST['identifiant'])) {
    $role = 'arbitre';
    $identifiant = $_POST['identifiant'];
    // Pour l'arbitre, on n'utilise pas les champs propres aux athlètes
    $profil = 'individuel';
    $sexe = '';
    $pays = '';
    $age = '';
    $discipline = '';
    $discipline_equipe = '';
    $record = $_POST['record'] ?? '00:00:00';
    $nom_equipe = '';
} else {
    // Sinon, c'est un athlète
    $role = 'athlete';
    // Déterminer si c'est un compte équipe ou individuel
    if (isset($_POST['nom_equipe']) && !empty($_POST['nom_equipe'])) {
        // Compte équipe
        $profil = 'equipe';
        $nom_equipe = $_POST['nom_equipe'];
        $sexe_equipe = $_POST['sexe_equipe'] ?? '';
        $discipline_equipe = $_POST['discipline_equipe'] ?? '';
        $record = $_POST['record'] ?? '00:00:00';
        // Les champs individuels restent vides
        $sexe = '';
        $age = '';
        $pays = '';
        $discipline = '';
    } else {
        // Compte individuel
        $profil = 'individuel';
        $sexe = $_POST['sexe'] ?? '';
        $discipline = $_POST['discipline'] ?? '';
        $age = $_POST['age'] ?? '';
        $pays = $_POST['pays'] ?? '';
        $record = $_POST['record'] ?? '00:00:00';
        // Les champs d'équipe sont vides
        $nom_equipe = '';
        $discipline_equipe = '';
    }
}

// Vérifier si l'email existe déjà
$recumail = $pdo->query("SELECT COUNT(*) FROM users WHERE email = '$email'");
$mailexist = $recumail->fetchColumn();
if ($mailexist > 0) {
    echo "Erreur : Cet email est déjà utilisé.";
    exit;
}

// Insertion dans la base de données (attention, ce code n'utilise pas de requêtes préparées)
$sql = "INSERT INTO users (
    nom, prenom, email, mot_de_passe, role, profil, 
    sexe, pays, age, discipline, discipline_equipe, record_officiel, 
    nom_equipe, identifiant
) VALUES (
    '$nom', '$prenom', '$email', '$hashedPassword', '$role', '$profil',
    '$sexe', '$pays', '$age', '$discipline', '$discipline_equipe', '$record',
    '$nom_equipe', " . (isset($identifiant) ? "'$identifiant'" : "''") . "
)";

if ($pdo->query($sql)) {
    echo "Inscription réussie ! <a href='../login.html'>Se connecter</a>";
} else {
    echo "Erreur lors de l'inscription.";
}
?>
