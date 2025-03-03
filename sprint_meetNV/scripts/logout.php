<?php
session_start();
// Détruit la session
session_unset();
session_destroy();
// Redirige vers la page de connexion
header("Location: ../login.html");
exit;
?>