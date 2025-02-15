<?php
session_start();
require_once '../includes/db_connect.php';

$email = $_POST['email'] ?? '';
$mot_de_passe = $_POST['mot_de_passe'] ?? '';

try {
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        
        // Redirige en fonction du rôle
        if ($user['role'] === 'admin') {
            header("Location: ../dashboard_admin.html");
        } elseif ($user['role'] === 'arbitre') {
            header("Location: ../dashboard_arbitre.html");
        } else {
            header("Location: ../dashboard_athlete.html");
        }
        exit;
    } else {
        echo "Email ou mot de passe incorrect.";
    }
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
