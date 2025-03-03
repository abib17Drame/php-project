<?php
require_once '../includes/db_connect.php';

// Récupère les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

// Détermine le rôle et les champs supplémentaires
if (isset($_POST['identifiant']) && !empty($_POST['identifiant'])) {
    $role = 'arbitre';
    $identifiant = $_POST['identifiant'];
    $profil = 'individuel';
    $sexe = '';
    $pays = '';
    $age = '';
    $discipline = '';
    $discipline_equipe = '';
    $record = $_POST['record'] ?? '00:00:00';
    $nom_equipe = '';
} else {
    $role = 'athlete';
    if (isset($_POST['nom_equipe']) && !empty($_POST['nom_equipe'])) {
        $profil = 'equipe';
        $nom_equipe = $_POST['nom_equipe'];
        $sexe_equipe = $_POST['sexe_equipe'] ?? '';
        $discipline_equipe = $_POST['discipline_equipe'] ?? '';
        $record = $_POST['record'] ?? '00:00:00';
        $sexe = '';
        $age = '';
        $pays = '';
        $discipline = '';
    } else {
        $profil = 'individuel';
        $sexe = $_POST['sexe'] ?? '';
        $discipline = $_POST['discipline'] ?? '';
        $age = $_POST['age'] ?? '';
        $pays = $_POST['pays'] ?? '';
        $record = $_POST['record'] ?? '00:00:00';
        $nom_equipe = '';
        $discipline_equipe = '';
    }
}

// Vérifie si l'email existe déjà
$sql = "SELECT COUNT(*) FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$count = mysqli_fetch_row($result)[0];

if ($count > 0) {
    echo "Erreur : Cet email est déjà utilisé.";
    exit;
}

// Insère l'utilisateur dans la base de données
$sql = "INSERT INTO users (
    nom, prenom, email, mot_de_passe, role, profil, 
    sexe, pays, age, discipline, discipline_equipe, record_officiel, 
    nom_equipe, identifiant
) VALUES (
    '$nom', '$prenom', '$email', '$mot_de_passe', '$role', '$profil',
    '$sexe', '$pays', '$age', '$discipline', '$discipline_equipe', '$record',
    '$nom_equipe', " . (isset($identifiant) ? "'$identifiant'" : "''") . "
)";

if (mysqli_query($conn, $sql)) {
    $user_id = mysqli_insert_id($conn); // Récupère l'ID de l'utilisateur inséré

    // Dossier pour stocker les fichiers (à la racine du projet)
    $upload_dir = "../../uploads/"; // Chemin relatif depuis sprint_meetNV/scripts/

    // Crée le dossier s'il n'existe pas
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir);
    }

    // Fonction pour récupérer l'extension d'un fichier
    function obtextension($filename) {
        $parts = explode(".", $filename); // Sépare le nom du fichier par "."
        return "." . end($parts); // Retourne la dernière partie (l'extension)
    }

    // Gestion des fichiers pour les athlètes individuels
    if ($role === 'athlete' && $profil === 'individuel') {
        // Fichier record
        if (!empty($_FILES['fichier_record_individuel']['name'])) {
            $record_file_name = $prenom . "_" . $user_id . "_record" . obtextension($_FILES['fichier_record_individuel']['name']);
            move_uploaded_file($_FILES['fichier_record_individuel']['tmp_name'], $upload_dir . $record_file_name);
        }

        // Pièce d'identité
        if (!empty($_FILES['piece_identite']['name'])) {
            $piece_identite_name = $prenom . "_" . $user_id . "_cn" . obtextension($_FILES['piece_identite']['name']);
            move_uploaded_file($_FILES['piece_identite']['tmp_name'], $upload_dir . $piece_identite_name);
        }

        // Diplôme secondaire
        if (!empty($_FILES['diplome']['name'])) {
            $diplome_name = $prenom . "_" . $user_id . "_ds" . obtextension($_FILES['diplome']['name']);
            move_uploaded_file($_FILES['diplome']['tmp_name'], $upload_dir . $diplome_name);
        }
    }

    // Gestion des fichiers pour les équipes
    if ($role === 'athlete' && $profil === 'equipe') {
        // Fichier record de l'équipe
        if (!empty($_FILES['fichier_record_equipe']['name'])) {
            $record_file_name = $nom_equipe . "_" . $user_id . "_record" . obtextension($_FILES['fichier_record_equipe']['name']);
            move_uploaded_file($_FILES['fichier_record_equipe']['tmp_name'], $upload_dir . $record_file_name);
        }
    }

    echo "Inscription réussie ! <a href='../login.html'>Se connecter</a>";
} else {
    echo "Erreur lors de l'inscription.";
}
?>