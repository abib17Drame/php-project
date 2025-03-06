<?php
session_start();
require_once '../includes/db_connect.php';

$email = $_POST['email'];
$mot_de_passe = $_POST['mot_de_passe'];

if ($email === "admin@sprintmeet.com" && $mot_de_passe === "admin") {
    $_SESSION['user_id'] = "admin";
    $_SESSION['role'] = "admin";
    header("Location: ../dashboard_admin.php");
    exit;
}

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        // Redirection selon le rôle
        if ($user['role'] === 'arbitre') {
            header("Location: ../dashboard_arbitre.php");
        } else {
            header("Location: ../dashboard_athlete.php");
        }
        exit;
    }
}

echo "Email ou mot de passe incorrect.";
?>
