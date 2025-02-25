<?php
require_once 'includes/db_connect.php';

$id = $_GET['id'];
$sql = "UPDATE courses SET statut_inscription = 
        CASE 
            WHEN statut_inscription = 'ouvert' THEN 'fermé'
            ELSE 'ouvert'
        END 
        WHERE id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header('Location: courses.php');
exit;
