<?php
session_start();
require_once '../includes/db_connect.php';

// Récupère les données du formulaire
$email = $_POST['email'];
$mot_de_passe = $_POST['mot_de_passe'];

// Requête SQL pour vérifier l'utilisateur
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    // Vérifie le mot de passe
    if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Redirige en fonction du rôle
        if ($user['role'] === 'admin') {
            header("Location: ../dashboard_admin.html");
        } elseif ($user['role'] === 'arbitre') {
            header("Location: ../dashboard_arbitre.php");
        } else {
            header("Location: ../dashboard_athlete.html");
        }
        exit;
    } else {
        echo "Email ou mot de passe incorrect.";
    }
} else {
    echo "Email ou mot de passe incorrect.";
}
?>